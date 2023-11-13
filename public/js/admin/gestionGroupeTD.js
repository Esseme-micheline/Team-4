function showEtudiant(id){
    $.get("/Admin/GroupeTD/TD/showEtudiantOne/" + id,
        function (etudiant, textStatus, jqXHR) {
            // console.log(etudiant[0]);
            document.getElementById('matricule').value = etudiant[0].matricule;
            document.getElementById('noms').value = etudiant[0].noms;
            document.getElementById('telephone').value = etudiant[0].telephone;
            document.getElementById('email').value = etudiant[0].email;
            $('#showEtudiantsModal').modal('toggle');
        },
    );
}
function editGroupeTd(id) {
    $.get("/Admin/GroupeTD/TD/edit?id=" + id,
        function (groupetd, textStatus, jqXHR) {
            document.getElementById('id').value = groupetd.id;
            document.getElementById('intitule').value = groupetd.intitule;
            document.getElementById('periode').value = groupetd.periode;
            document.getElementById('capacite').value = groupetd.capacite;
            document.getElementById('salle').value = groupetd.salle;
            $('#editGroupeTDModal').modal('toggle');
        },
    );
}
$('#editGroupeTDForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let intitule = $('#intitule').val();
    let periode = $('#periode').val();
    let capacite = $('#capacite').val();
    let salle = $('#salle').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/GroupeTD/TD/update",
        data: {
            id: id,
            intitule: intitule,
            periode:periode,
            capacite:capacite,
            salle:salle,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.intitule)
            $('#editGroupeTDModal').modal('toggle')
            $('#editGroupeTDForm')[0].reset()
        }
    });

});
