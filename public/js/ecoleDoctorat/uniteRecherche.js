function editUniteRecherche(id){
    $.get('/Ecole_Doctorat/Unite_Recherche/edit/'+id, function(niveau){
        document.getElementById('id').value = niveau.id;
            document.getElementById('code').value = niveau.code;
            document.getElementById('intitule').value = niveau.intitule;
            $('#editUniteRechercheModal').modal('toggle');
    })
}
$('#editUniteRechercheForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let code = $('#code').val();
    let intitule = $('#intitule').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Ecole_Doctorat/Unite_Recherche/update",
        data: {
            id: id,
            code: code,
            intitule: intitule,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.code)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.intitule)
            $('#editUniteRechercheModal').modal('toggle')
            $('#editUniteRechercheForm')[0].reset()
        }
    });

});
