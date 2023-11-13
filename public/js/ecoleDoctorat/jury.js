
function editJury(id) {
    $.get("/Ecole_Doctorat/Jury/edit/" + id,
        function (jury, textStatus, jqXHR) {
            document.getElementById('id').value = jury.jury.id;
            document.getElementById('noms').value = jury.jury.noms;
            document.getElementById('email').value = jury.jury.email;
            document.getElementById('grade').value = jury.jury.grade;
            document.getElementById('telephone').value = jury.jury.telephone;
            document.getElementById('universite').value = jury.jury.universite;
            document.getElementById('faculte').value = jury.jury.faculte;
            document.getElementById('departement').value = jury.jury.departement;
            $('#editJuryModal').modal('toggle');
        },
    );
}
$('#editJuryForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let grade = $('#grade').val();
    let noms = $('#noms').val();
    let email = $('#email').val();
    let telephone = $('#telephone').val();
    let universite = $('#universite').val();
    let faculte = $('#faculte').val();
    let departement = $('#departement').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Ecole_Doctorat/Jury/update",
        data: {
            id: id,
            grade: grade,
            noms: noms,
            telephone: telephone,
            email: email,
            universite: universite,
            faculte: faculte,
            departement: departement,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.id + ' td:nth-child(2)').text(response.noms)
            $('#sid' + response.id + ' td:nth-child(3)').text(response.email)
            $('#editJuryModal').modal('toggle')
            $('#editJuryForm')[0].reset()
        }
    });

});
