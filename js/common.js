
var _data = [];
var _ids = [];
var id = 0;
var onefoo = 0;


$('pre#content').click(function() {
    if (!$(this).html())
        return false;

    if (onefoo) {
        onefoo = 0;
        return false;
    }

    if (!$(this).find('textarea').val()) {

        $(this).html(
                "<textarea style='width: 1100px; height: " + $(this).height() + "px;'>" + $(this).html() + "</textarea>" +
                "<br />" +
                "<button onclick=save()>Save</button> <button onclick=cancel()>Cancel</button>");
        $(this).find('textarea').focus();
    }
});

function save() {
    $.ajax({type: "POST",
        data: {
            content: $("textarea").val(),
            action: 'save',
            id: id
        },
        dataType: 'JSON',
        url: 'ajax.php',
        success: function(data) {
            //alert(data);
            $('#content').text($("textarea").val());
        }
    });
}

function cancel() {
    onefoo = 1;
    $('#content').text($("textarea").val());
}

$('li a').click(function() {
    var link = $(this).data('id');
    $.ajax({
        url: 'ajax.php',
        type: 'POST',
        dataType: 'JSON',
        data: 'action=get&id=' + link,
        success: function(data) {
            $('#content').html(data.content).show();
            id = link;
        }
    });
});

$('#keyword').typeahead({
    source: function(query, process) {
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            dataType: 'JSON',
            data: 'action=search&query=' + query,
            success: function(data) {
                _data = data.items;
                _ids = data.ids;

                process(_data);
            }
        });
    },
    updater: function(item) {
        var link;
        for (var i = 0; i < _data.length; i++) {
            if (_data[i] == item) {
                link = _ids[i];
            }
        }
        console.log(link);
        $.ajax({
            url: 'ajax.php',
            type: 'POST',
            dataType: 'JSON',
            data: 'action=get&id=' + link,
            success: function(data) {
                $('#content').html(data.content).show();
                id = link;
            }
        });

    }
});

$(document).ready(function() {
    $('#keyword').focus();
});
