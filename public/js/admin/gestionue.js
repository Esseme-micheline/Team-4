function editUe(id) {
    $.get("/Admin/UE/edit?id=" + id,
        function (filiere, textStatus, jqXHR) {
            document.getElementById('id').value = filiere.id;
            document.getElementById('code').value = filiere.code;
            document.getElementById('intitule').value = filiere.intitule;
            $('#editUeModal').modal('toggle');
        },
    );
}
$('#editUeForm').submit(function (e) {
    e.preventDefault();

    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/UE/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editUeModal').modal('toggle')
            $('#editUeForm')[0].reset()
        }
    });

});
