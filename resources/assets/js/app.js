
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window._ = require('lodash');
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');
window.Pusher = require('pusher-js');
import Echo from "laravel-echo";

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'f07b66423c9697f0bdb2',
    cluster: 'eu',
    encrypted: true
});


var notifications = [];

const NOTIFICATION_TYPES = {
    follow: 'App\\Notifications\\UserAddFriend'
};

$(document).ready(function() {
    if(Laravel.userId) {
        $.get('/notifications', function (data) {
            addNotifications(data, "#notifications");
        });
        window.Echo.private(`App.User.${Laravel.userId}`)
        .notification((notification) => {
            addNotifications([notification],'#notifications');
        });
    }
});

function addNotifications(newNotifications, target) {
    notifications = _.concat(notifications, newNotifications);
    showNotifications(notifications, target);
}

function showNotifications(notifications, target) {
    if(notifications.length) {
        var htmlElements = notifications.map(function (notification) {
            return makeNotification(notification);
        });
        $(target + 'Menu').html(htmlElements.join(''));
        $(target).addClass('has-notifications')
    } else {
        $(target + 'Menu').html('<li class="dropdown-header">No notifications</li>');
        $(target).removeClass('has-notifications');
    }
}
// Make a single notification string
function makeNotification(notification) {
    var to = routeNotification(notification);
    var notificationText = makeNotificationText(notification);
    return '<li><a href="' + to + '">' + notificationText + '</a></li>';
}

// get the notification route based on it's type
function routeNotification(notification) {
    var to = '33';
    if(notification.type === NOTIFICATION_TYPES.follow) {
        to = 'profile/' + notification.data.follower_id;
    }
    return '/' + to;
}

// get the notification text based on it's type
function makeNotificationText(notification) {
    var text = '';
    if(notification.type === NOTIFICATION_TYPES.follow) {
        const name = notification.data.follower_name;
        text += '<strong>' + name + '</strong> Added you';
    }
    return text;
}

