function fetchNiveau(search) {
    if(search==''){
        document.getElementById('tbodys').innerHTML = ""
    }else{

        document.getElementById('tbodys').innerHTML = ""
    }
    $.get('/Admin/Niveau/show?search=' + search, function (niveau) {
        let cmpt=1
        $.each(niveau, function (key, item) {
            $('#tbodys').append('<tr id="sid'+ item.id+'">\
            <th scope="row">'+cmpt+'</th>\
            <td>'+item.code+'</td>\
            <td>'+item.intitule+'</td>\
            <td><a href="" class="btn btn-success"><i class="fa fa-plus-circle"\
                        aria-hidden="true"></i> Voir plus</a>\
                <a href="javascript:void(0)" onclick="editNiveau('+item.id+')"\
                    class="btn btn-danger"><i class="fa fa-edit"\
                        aria-hidden="true"></i>Update</a>\
                <a href="/Admin/Niveau/delete/'+item.id+'"\
                    class="btn btn-secondary"><i class="fa fa-trash"\
                        aria-hidden="true"></i></i>Delete</a>\
            </td>\
        </tr>')
        cmpt += 1
        });
    })

}
function editNiveau(id){
    $.get('/Admin/Niveau/edit?id='+id, function(niveau){
        document.getElementById('id').value = niveau.id;
            document.getElementById('code').value = niveau.code;
            document.getElementById('intitule').value = niveau.intitule;
            $('#editNiveauModal').modal('toggle');
    })
}
$('#editNiveauForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/Niveau/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editNiveauModal').modal('toggle')
            $('#editNiveauForm')[0].reset()
        }
    });

});
