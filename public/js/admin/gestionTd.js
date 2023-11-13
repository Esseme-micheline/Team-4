function editTd(id) {
    $.get("/Admin/TD/edit?id=" + id,
        function (td, textStatus, jqXHR) {
            document.getElementById('id').value = td.id;
            document.getElementById('code').value = td.code;
            document.getElementById('intitule').value = td.intitule;
            $('#editTdModal').modal('toggle');
        },
    );
}
function editTdSpeciale(id) {
    $.get("/Admin/TD/editTdSpecial?id=" + id,
        function (tdSpecial, textStatus, jqXHR) {
            document.getElementById('idT').value = tdSpecial.id;
            document.getElementById('codeT').value = tdSpecial.code;
            document.getElementById('intituleT').value = tdSpecial.intitule;
            document.getElementById('prix').value = tdSpecial.prix;
            $('#editdSpecialModal').modal('toggle');
        },
    );
}
$('#editTdForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/TD/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editTdModal').modal('toggle')
            $('#editTdForm')[0].reset()
        }
    });

});

$('#editTdSpecialeForm').submit(function (e) {
    e.preventDefault();
    let id = $('#idT').val();
    let code = $('#codeT').val();
    let intitule = $('#intituleT').val();
    let prix = $('#prix').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/TD/updateTdSpecial",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            prix: prix,
            _token: _token
        },
        success: function (response) {
            $('#sids' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sids' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#sids' + response.id + ' td:nth-child(5)').text(response.prix)
            $('#editdSpecialModal').modal('toggle')
            $('#editTdSpecialeForm')[0].reset()
        }
    });

});
