$(document).ready(function () {
    $('#preview').click(function () {
        var message = $('#text').val();
        $('#result').html(message);
        return false;
    })
});