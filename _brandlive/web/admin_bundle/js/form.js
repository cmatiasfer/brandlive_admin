$(window).on('load', function () {
 
});    

$(document).ready(function () {
    if($('#clientsGroups')[0]){
        var clientsGroups = $('#clientsGroups');
        var listClientsGroups = JSON.parse(clientsGroups.val());
        console.log(listClientsGroups);
        $.each(listClientsGroups, function(i,o){
            $('#clients_groups').find('input[value="'+o.id+'"]').attr('checked','checked');
        });
    }
});
