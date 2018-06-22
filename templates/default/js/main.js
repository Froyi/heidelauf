function hideNotifications() {
    $('.js-notification-container').hide();
}

function refresh() {
    let $refreshContainer = $('.js-ranking'),
    $donationSumContainer = $('.js-donation-sum');

    $.ajax({
        type: 'POST',
        url: 'index.php?route=refresh',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                $refreshContainer.html(response.view);
                if (response.donationSum || response.donationSum === 0) {
                    $donationSumContainer.html(response.donationSum)
                }
            }
        }
    })
}

$(document).ready(function () {
    window.setTimeout(hideNotifications, 5000); // 5 seconds
    window.setTimeout(window.setInterval(refresh, 3000), 5000); // 3 seconds

    const countdown = new Countdown({
        selector: '.js-countdown',
        msgBefore: "- - -",
        msgAfter: "00:00:00",
        msgPattern: "{hours}:{minutes}:{seconds}",
        dateStart: START,
        dateEnd: END,
        leadingZeros: true
    });

    $('.js-countdown').on('countdownEnd', function() {
        location.href = 'index.php?route=finish';
    });

    const tillStart = new Countdown({
        selector: '.js-till-start',
        msgBefore: "",
        msgAfter: "",
        msgPattern: "{hours}:{minutes}:{seconds}",
        dateStart: new Date(),
        dateEnd: START,
        leadingZeros: true,
    });

    $('.js-till-start').on('countdownEnd', function() {
        $(this).closest('.js-till-start-container').remove();
    });
});

$(document).on('click', '.js-notification', function () {
    hideNotifications();
});

$(document).on('click', '.js-delete-team', function (e) {
    if (confirm('Wirklich löschen?') === false) {
        e.preventDefault();
    }
});

$(document).on('click', '.js-edit-team', function () {
    let teamId = $(this).data('teamId'),
        $teamEditContainer = $('.js-edit-team-container');

    // noinspection JSUnresolvedVariable
    $.ajax({
        type: 'POST',
        url: 'index.php?route=editTeam',
        dataType: 'json',
        data: {
            teamId: teamId
        },
        success: function (response) {
            if (response.status === 'success') {
                $teamEditContainer.html(response.view);
                $teamEditContainer.removeClass('invisible');
            }
        }
    })
});