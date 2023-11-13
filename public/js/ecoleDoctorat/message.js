function voirMessage(id) {
    $.get("/Ecole_Doctorat/Message/edit/" + id,
        function (message, textStatus, jqXHR) {
            document.getElementById('titre_m').innerHTML = message.titre;
            document.getElementById('message_m').innerHTML = message.contenu;
            $('#voirMessageModal').modal('toggle');
        },
    );
}
function editMessage(id) {
    $.get("/Ecole_Doctorat/Message/edit/" + id,
        function (message, textStatus, jqXHR) {
            document.getElementById('id').value = message.id;
            document.getElementById('titre').value = message.titre;
            document.getElementById('contenu').innerHTML = message.contenu;
            $('#editNewsModal').modal('toggle');
        },
    );
}
$('#editNewForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let titre = $('#titre').val();
    let contenu = $('#contenu').val();
    let _token = $("input[name=_token]").val();
    // console.log(contenu);
    $.ajax({
        type: "POST",
        url: "/Ecole_Doctorat/Message/edit",
        data: {
            id: id,
            titre: titre,
            contenu: contenu,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.titre)
            $('#editNewsModal').modal('toggle')
            $('#editNewForm')[0].reset()
        }
    });

});
