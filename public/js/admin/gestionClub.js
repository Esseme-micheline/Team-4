function fetchClub(search) {
    if(search==''){
        document.getElementById('tbodys').innerHTML = ""
    }else{
        document.getElementById('tbodys').innerHTML = ""
    }
    let dept=""
    $.get('/Admin/Club/showC?search=' + search, function (response) {
        let cmpt=1
        $.each(response.club, function (key, item) {
            $.each(response.departement, function (keys, items) {
                if(item.departement_id==items.id){
                    dept=items.code
                }
            });

            $('#tbodys').append('<tr id="sid'+ item.id+'">\
            <th scope="row">'+cmpt+'</th>\
            <td>'+item.code+'</td>\
            <td>'+item.intitule+'</td>\
            <td>'+dept+'</td>\
            <td><a href="/Admin/Club/Action/'+item.id+'" class="btn btn-success"><i class="fa fa-plus-circle"\
                        aria-hidden="true"></i> Voir plus</a>\
                <a href="javascript:void(0)" onclick="editClub('+item.id+')"\
                    class="btn btn-danger"><i class="fa fa-edit"\
                        aria-hidden="true"></i>Update</a>\
                <a href="/Admin/Club/delete/'+item.id+'"\
                    class="btn btn-secondary"><i class="fa fa-trash"\
                        aria-hidden="true"></i></i>Delete</a>\
            </td>\
        </tr>')
        cmpt += 1
        });
    })
}

function editClub(id) {
    $.get("/Admin/Club/edit?id=" + id,
        function (club, textStatus, jqXHR) {
            document.getElementById('id').value = club.id;
            document.getElementById('code').value = club.code;
            document.getElementById('intitule').value = club.intitule;
            $('#editClubModal').modal('toggle');
        },
    );
}
$('#editClubForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/Club/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editClubModal').modal('toggle')
            $('#editClubForm')[0].reset()
        }
    });

});

