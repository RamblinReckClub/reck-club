var express = require('express');
var rtr = express.Router();
var mmt = require('moment');
var Utils = require('./utils');

function onComplete(error, res, successMessage) {
    if (error) {
        res.status(400).send({
            "status" : "bad",
            "message": error
        });
    } else {
        res.status(200).send({
            status: "ok",
            message: successMessage
        });
    }
}

function getEventList(firebase, success, error) {
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
        .once('value')
        .then(function (snapshot) {
            var dataArr = Utils.cleanSnapshotArray(snapshot);
            dataArr.sort(function(a, b) {
               return a.date < b.date;
            });
            success(dataArr);

        }).catch(function (err) {
        error(err);
    });
}

function getEventListCount(firebase, count, success, error) {
    firebase
        .database()
        .ref('event')
        .limitToLast(Math.min(parseInt(count), 100))
        .once('value')
        .then(function (snapshot) {
            var dataArr = Utils.cleanSnapshotArray(snapshot);
            success(dataArr);
        }).catch(function (err) {
            error(err);
        });
}

function getEventListDate(firebase, year, month, success, error) {
    if (parseInt(month) < 10 && !month.includes('0')) {
        month = '0' + month;
    }
    var firstOfMonth = year + '-' + month + '-01';
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .startAt(Date.parse(firstOfMonth))
        .endAt(Date.parse(mmt(firstOfMonth).endOf('month').hour(23).minute(59).second(59).format('YYYY-MM-DD')))
        .once('value')
        .then(function (snapshot) {
            var dataArr = Utils.cleanSnapshotArray(snapshot);
            success(dataArr);
        }).catch(function (err) {
            error(err);
        });
}

function getEventListRecent(firebase, year, month, count, success, error) {
    if (parseInt(month) < 10 && !month.includes('0')) {
        month = '0' + month;
    }
    var firstOfMonth = year + '-' + month + '-01';
    var cnt = (count != null) ? parseInt(count) : 10;
    firebase
        .database()
        .ref('event')
        .orderByChild('date')
        .startAt(Date.parse(firstOfMonth))
        .endAt(mmt(Date.now()).hour(23).minute(59).second(59).valueOf())
        .limitToLast(Math.min(parseInt(cnt), 100))
        .once('value')
        .then(function (snapshot) {
            var dataArr = Utils.cleanSnapshotArray(snapshot);
            success(dataArr);
        }).catch(function (err) {
            error(err);
        });
}

function createEvent(firebase, req, res) {
    firebase
        .database()
        .ref('event')
        .push({
            name: req.body.name,
            date: mmt(req.body.date).hour(12).minute(0).second(0).valueOf(),
            points: req.body.points,
            bonus: (req.body.bonus === "true"),
            family: (req.body.family === "true"),
            type: req.body.type,
            createdAt: Date.now(),
            updatedAt: Date.now()
        }, function(error) {
            onComplete(error, res, "Event created successfully!")
        });
}

function updateEvent(firebase, req, res) {
    var cleanedRequestData = {
        name: req.body.name,
        date: mmt(req.body.date).hour(12).minute(0).second(0).valueOf(),
        points: parseInt(req.body.points),
        bonus: req.body.bonus,
        family: req.body.family,
        type: req.body.type,
        updatedAt: Date.now()
    };
    firebase
        .database()
        .ref('event/' + req.params.id)
        .set(cleanedRequestData, function(error) {
            if (error != null) {
                var updates = {};
                firebase.database().ref('user').on('value', function(snapshot) {
                    if (snapshot != null) {
                        snapshot.forEach(function(item) {
                            if (item.val().events.keys().includes(req.params.id)) {
                                var userEvent = item.val().events[req.params.id];
                                updates['user/' + item.key + '/events/' + req.params.id + '/name'] = cleanedRequestData.name;
                                updates['user/' + item.key + '/events/' + req.params.id + '/date'] = cleanedRequestData.date;
                                updates['user/' + item.key + '/events/' + req.params.id + '/points'] = parseInt(cleanedRequestData.points);
                                updates['user/' + item.key + '/events/' + req.params.id + '/type'] = cleanedRequestData.type;
                                updates['user/' + item.key + '/points'] = parseInt(item.points) - parseInt(userEvent.points) + parseInt(cleanedRequestData.points);
                            }
                        });
                        snapshot.ref.update(update, function(err) {
                            onComplete(err, res, "Update event successful: Updates applied to user.events applied and update of event metadata completed");
                        });
                    }

                });
            } else {
                onComplete(error, res, "Event updated successfully!")
            }
        });
}

// REMINDER: WRITE CLOUD FUNCTION TO UPDATE USERS TO DROP THIS EVENT FROM USERS.EVENTS
function deleteEvent(firebase, req, res) {
    firebase
        .database()
        .ref('event/' + req.params.id)
        .remove()
        .then(function () {
            var updates = {};
            firebase
                .database()
                .ref('user')
                .on('value', function(snapshot) {
                    if (snapshot != null) {
                        snapshot.forEach(function(item) {
                            if (item.val().events.keys().includes(req.params.id)) {
                                var userEvent = item.val().events[req.params.id];
                                updates['user/' + item.key + '/events/' + req.params.id] = false;
                                updates['user/' + item.key + '/points'] = parseInt(item.points) - parseInt(userEvent.points);
                            }
                        });
                        snapshot.ref.update(update, function(err) {
                            onComplete(err, res, "Remove successful: Updates applied to user.events applied and deletion of event completed");
                        });
                    }
                });
        })
        .catch(function (error) {
            onComplete(error, res, "Remove failed: " + error.message);
        });
}

function addEventToUser(firebase, req, res) {
    var userId = firebase.auth().currentUser.uid;
    // REMINDER: change user.events retrieval to get keys!!!
    // REMINDER: change events.attendees retrieval to get user keys if value is true!!!
    var removedEvents = JSON.parse(req.body.removedEvents);
    console.log("Recieved removed: " + JSON.stringify(removedEvents));
    var newEvents = JSON.parse(req.body.newEvents);
    console.log("Cleaned new: " + newEvents);
    var coreRef = firebase.database().ref();
    var userRef = coreRef.child('user/' + userId);
    var pointsDelta = 0;
    var promises = [];
    if (newEvents.length > 0) {
        newEvents.forEach(function(item) {
            console.log('New item');
            console.log('id: ' + item.id);
            console.log('points: ' + item.points);
            var eventsRef = coreRef.child('event/' + item.id);
            promises.push(
                eventsRef
                    .child("attendees")
                    .child(userId)
                    .set(true)
            );

            promises.push(
                userRef
                    .child('events')
                    .child(item.id)
                    .set({
                        attended: true,
                        points: item.points,
                        name: item.name,
                        type: item.type,
                        date: item.date
                    })
            );
            pointsDelta += parseInt(item.points);
        });
    }

    if (removedEvents.length > 0) {
        removedEvents.forEach(function(item) {
            var eventsRef = coreRef.child('event/' + item.id);
            promises.push(
                eventsRef
                    .child("attendees")
                    .child(userId)
                    .remove()
            );

            promises.push(
                userRef
                    .child('events')
                    .child(item.id)
                    .remove()
            );
            pointsDelta -= parseInt(item.points);
        });
    }

    if (promises.length > 0) {
        promises.push(
            userRef
                .child('points')
                .set(parseInt(req.body.points) + pointsDelta)
        );
        console.log(promises);

        Promise
            .all(promises)
            .then(function(snaps) {
                console.log(snaps);
                res.status(200).send({
                    status: "ok",
                    message: "Events added successfully",
                    detailedMessage: {
                        message: "Events added successfully"
                    }
                });
            }).catch(function(err) {
                res.status(400).send({
                    status: "ok",
                    message: "Error adding events to user " + userId ,
                    detailedMessage: err
                });
        });
    }
}

module.exports = function(firebase) {
    /* GET events listing. */
    rtr.get('/', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = mmt().format('YYYY');
            var month = mmt().format('MM');
            getEventListDate(firebase, year, month, function (results) {
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snapshot) {
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: Utils.cleanUser(snapshot),
                            moment: mmt,
                            month: month,
                            events: results,
                            FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('error', {
                            error: err
                        });
                    });
            }, function(err) {
                console.log('ERROR loading /events: ' + err);
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snapshot) {
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: Utils.cleanUser(snapshot),
                            moment: mmt,
                            events: [],
                            month: month,
                            FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('error', {
                            error: err
                        });
                    });
            });
        } else {
            res.redirect('/login');
        }
    });

    rtr.get('/list', function(req, res, next) {
        if (firebase.auth().currentUser) {
            getEventList(firebase, function(results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function (err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/:count', function(req, res, next) {
        if (firebase.auth().currentUser) {
            getEventListCount(firebase, req.params.count, function (results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function (err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/year/:year/month/:month', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = req.params.year;
            var month = req.params.month;
            getEventListDate(firebase, year, month, function (results) {
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snap) {
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: Utils.cleanUser(snap),
                            moment: mmt,
                            events: results,
                            month: month,
                            FIREBASE_PROJECT_ID: process.env.FIREBASE_PROJECT_ID
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('error', {
                            error: err
                        });
                });
            }, function (evErr) {
                console.log('ERROR: ' + evErr);
                firebase
                    .database()
                    .ref('user/' + firebase.auth().currentUser.uid)
                    .once('value')
                    .then(function(snap) {
                        res.render('events', {
                            title: "Events | Ramblin' Reck Club",
                            user: Utils.cleanUser(snap),
                            moment: mmt,
                            events: [],
                            month: month
                        });
                    }).catch(function(err) {
                        console.log('ERROR: ' + err);
                        res.render('error', {
                            error: err
                        });
                });
            });
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/list/recent/:count', function(req, res, next) {
        if (firebase.auth().currentUser) {
            var year = mmt(Date.now()).year();
            var month = mmt(Date.now()).month();
            getEventListRecent(firebase, year, month, req.params.count, function (results) {
                res.status(200).send({
                    "status" : "ok",
                    "events" : results
                });
            }, function(err) {
                res.status(400).send({
                    "status" : "bad",
                    "message": err,
                    "events" : []
                });
            })
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required",
                "events" : []
            });
        }
    });

    rtr.get('/create', function(req, res) {
        if (firebase.auth().currentUser) {
            res.render('create-event', {
                title: "Create Event | Ramblin' Reck Club",
                user: firebase.auth().currentUser,
                moment: mmt
            });
        } else {
            res.redirect('/login');
        }
    });

    rtr.put('/create', function(req, res, next) {
        if (firebase.auth().currentUser) {
            createEvent(firebase, req, res);
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    rtr.get('/update/:id', function(req, res) {
        if (firebase.auth().currentUser) {
            firebase
                .database()
                .ref('event/' + req.params.id)
                .once('value')
                .then(function(snapshot) {
                    var event = snapshot.val();
                    event.id = snapshot.key;
                    res.render('update-event', {
                        title: "Update Event | Ramblin' Reck Club",
                        user: firebase.auth().currentUser,
                        event: event,
                        moment: mmt
                    });
                })
                .catch(function(err) {
                    res.render('error', {
                        message: "Event " + req.params.id + " not found",
                        error: err
                    });
                });
        } else {
            res.redirect('/login');
        }
    });

    rtr.put('/update/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            updateEvent(firebase, req, res);
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    rtr.delete('/delete/:id', function(req, res, next) {
        if (firebase.auth().currentUser) {
            deleteEvent(firebase, req, res);
        } else {
            res.status(401).send({
                "status" : "bad",
                "message": "login required"
            });
        }
    });

    rtr.put('/add-event', function(req, res) {
        if (firebase.auth().currentUser) {
            addEventToUser(firebase, req, res);
        } else {
            res.status(401).send({
                status:"bad",
                message: "login required",
                detailedMessage: {
                    message: "Access unauthorized. login required."
                }
            })
        }
    });

    return {
        router: rtr,
        getEventList: getEventList,
        getEventListRecent: getEventListRecent,
        getEventListCount: getEventListCount,
        getEventListData: getEventListDate
    }
};
