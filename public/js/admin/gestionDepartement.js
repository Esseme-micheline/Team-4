function fetchDepartement(search) {
    if(search==''){
        document.getElementById('tbodys').innerHTML = ""
        $.get('/Admin/Departement/show?search=' + search, function (departement) {
            let cmpt=1
            $.each(departement, function (key, item) {
                $('#tbodys').append('<tr id="sid'+ item.id+'">\
                <th scope="row">'+cmpt+'</th>\
                <td>'+item.code+'</td>\
                <td>'+item.intitule+'</td>\
                <td><a href="/Admin/Departement/Action/'+item.id+'" class="btn btn-success"><i class="fa fa-plus-circle"\
                            aria-hidden="true"></i> Voir plus</a>\
                    <a href="javascript:void(0)" onclick="editDepartement('+item.id+')"\
                        class="btn btn-danger"><i class="fa fa-edit"\
                            aria-hidden="true"></i>Update</a>\
                    <a href="/Admin/Departement/delete/'+item.id+'"\
                        class="btn btn-secondary"><i class="fa fa-trash"\
                            aria-hidden="true"></i></i>Delete</a>\
                </td>\
            </tr>')
            cmpt += 1
            });
        })
    }else{
        document.getElementById('tbodys').innerHTML = ""
        $.get('/Admin/Departement/show?search=' + search, function (departement) {
            let cmpt=1
            $.each(departement, function (key, item) {
                $('#tbodys').append('<tr id="sid'+ item.id+'">\
                <th scope="row">'+cmpt+'</th>\
                <td>'+item.code+'</td>\
                <td>'+item.intitule+'</td>\
                <td><a href="/Admin/Departement/Action/'+item.id+'" class="btn btn-success"><i class="fa fa-plus-circle"\
                            aria-hidden="true"></i> Voir plus</a>\
                    <a href="javascript:void(0)" onclick="editDepartement('+item.id+')"\
                        class="btn btn-danger"><i class="fa fa-edit"\
                            aria-hidden="true"></i>Update</a>\
                    <a href="/Admin/Departement/delete/'+item.id+'"\
                        class="btn btn-secondary"><i class="fa fa-trash"\
                            aria-hidden="true"></i></i>Delete</a>\
                </td>\
            </tr>')
            cmpt += 1
            });
        })
    }

}

function editDepartement(id) {
    $.get("/Admin/Departement/edit?id=" + id,
        function (departement, textStatus, jqXHR) {
            document.getElementById('id').value = departement.id;
            document.getElementById('code').value = departement.code;
            document.getElementById('intitule').value = departement.intitule;
            $('#editDepartementModal').modal('toggle');
        },
    );
}
$('#editDepartementForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/Departement/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editDepartementModal').modal('toggle')
            $('#editDepartementForm')[0].reset()
        }
    });

});

