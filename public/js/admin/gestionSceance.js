function editSceanceTd(id) {
    $.get("/Admin/SeanceTD/edit?id=" + id,
        function (td, textStatus, jqXHR) {
            document.getElementById('id').value = td.id;
            document.getElementById('date').value = td.date;
            document.getElementById('intitule').value = td.intitule;
            document.getElementById('description').innerHTML = td.description;
            document.getElementById('heureDebut').value = td.heureDebut;
            document.getElementById('heureFin').value = td.heureFin;
            document.getElementById('salle').value = td.salle;
            $('#editSceanceTDModal').modal('toggle');
        },
    );
}
$('#editSceanceTDForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let salle = $('#salle').val();
    let intitule = $('#intitule').val();
    let date = $('#date').val();
    let heureDebut = $('#heureDebut').val();
    let heureFin = $('#heureFin').val();
    let description=$('#description').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/SeanceTD/update",
        data: {
            id: id,
            salle: salle,
            heureDebut:heureDebut,
            intitule: intitule,
            heureFin:heureFin,
            date:date,
            description:description,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.intitule)
            document.getElementById('description_sean'+response.id).innerHTML=response.description
            // $('#sid' + response.id + ' td:nth-child(3)').text(response.description)
            $('#sid' + response.id + ' td:nth-child(4)').text(response.date)
            $('#sid' + response.id + ' td:nth-child(5)').text(response.heureDebut+'H - '+response.heureFin+'H')
            $('#sid' + response.id + ' td:nth-child(6)').text(response.salle)
            $('#editSceanceTDModal').modal('toggle')
            $('#editSceanceTDForm')[0].reset()
        }
    });

});

