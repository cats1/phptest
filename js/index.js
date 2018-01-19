function showFileMessage($filename) {
    $("#modalshowbody").empty();
    $.ajax({
        url: './php/common.php?action=checkFile&&filename=' + $filename,
        type: 'get',
        success: function(data) {
            $("#showmessmodal").modal("show");
            $("#modalshowbody").html(data);
        }
    });
}
function updateFileMessage($filename){
    $("#modalshowbody").empty();
    $.ajax({
        url: './php/common.php?action=updateFile&&filename=' + $filename,
        type: 'get',
        success: function(data) {
            $("#showmessmodal").modal("show");
            $("#modalshowbody").append('<textarea rows="10" style="width:100%;"></textarea>');
            $("#modalshowbody textarea").val(data);
        }
    });
}
function showFolderMessage($filename) {
    /*$("#modalshowbody").empty();
    $.ajax({
        url: './php/common.php?action=checkFolder&&filename=' + $filename,
        type: 'get',
        success: function(data) {
           $("#modalshowbody").html(data);
        }
    });*/
}