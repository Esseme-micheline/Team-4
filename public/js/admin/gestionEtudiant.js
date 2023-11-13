function fetchEtudiant(noms) {
    document.getElementById('tbodys').innerHTML = "";
    document.getElementById('pagination').innerHTML = "";
    let fil = ""
    let ses = ""
    $.ajax({
        type: "GET",
        url: "/Admin/Etudiant/showEt?search=" + noms,
        success: function (response) {
            console.log(response);
            let cmpt = 1
            $.each(response.etudiants, function (key, item) {
                $.each(response.filieres, function (keys, items) {
                    if (item.filiere_id == items.id) {
                        fil = items.code
                    }
                });
                $.each(response.niveaux, function (keyss, itemss) {
                    if (itemss.id == item.niveau_id) {
                        ses = itemss.code
                    }
                });
                $('tbody').append('<tr id="sid' + item.id + '">\
                                    <th scope="row">' + cmpt + '</th>\
                                    <td>' + item.noms + '</td>\
                                    <td>' + item.matricule + '</td>\
                                    <td>' + fil + '</td>\
                                    <td>' + ses + '</td>\
                                    <td><a onclick="return confirm("Voulez vous reinitialiser le mot de passe de cet etudiant ?")"\
                                                href="/Admin/Etudiant/reset/' + item.id + '"\
                                                class="btn btn-warning"><i class="fa-solid fa-repeat"></i>\
                                                Reinitialiser </a>\
                                    <a href="javascript:void(0)" onclick="editEtudiant(' + item.id + ')" class="btn btn-danger" style="font-weight:600;"> <i class="fa fa-edit" aria-hidden="true"></i>Update</a>\
                                    <a href="/Admin/Etudiant/delete/' + item.id + '" class="btn btn-secondary" style="font-weight:600;"> <i class="fa fa-trash" aria-hidden="true"></i>Delete</a></td>\
                                    </tr>')
                cmpt += 1

            });



        }
    });
}
function editEtudiant(id) {
    console.log('ok');
    $.get("/Admin/Etudiant/edit/" + id,
        function (Etudiant, textStatus, jqXHR) {
            document.getElementById('id').value = Etudiant.id;
            document.getElementById('matricule').value = Etudiant.matricule;
            document.getElementById('noms').value = Etudiant.noms;
            document.getElementById('telephone').value = Etudiant.telephone;
            document.getElementById('email').value = Etudiant.email;
            $('#editEtudiantModal').modal('toggle');
        },
    );
}
function editNiveauEtudiant(id) {
    console.log("ok");
    let ses = "";
    let niveau_id=0
    $.get("/Admin/Etudiant/edit/" + id,
        function (Etudiant, textStatus, jqXHR) {
            niveau_id=Etudiant.niveau_id;
        },
    );
    console.log(niveau_id);


}
// if (Etudiant.niveau_id == 3) {
//     let niveau_id = 1;
//     $.ajax({
//         type: "POST",
//         url: "/Admin/Etudiant/update",
//         data: {
//             id: id,
//             niveau_id: niveau_id
//         },
//         success: function (response) {
//             $.each(response.niveaux, function (keyss, itemss) {
//                 if (itemss.id == item.niveau_id) {
//                     ses = itemss.code
//                 }
//             });
//             $('#sid' + response.etudiant.id + ' td:nth-child(5)').text(ses)
//         }
//     });
// } else if (Etudiant.niveau_id == 2) {
//     console.log('okd');
// } else if (Etudiant.niveau_id == 3) {
//     console.log('oke');
// }
$('#editEtudiantForm').submit(function (e) {
    e.preventDefault();
    let id = $('#id').val();
    let matricule = $('#matricule').val();
    let noms = $('#noms').val();
    let telephone = $('#telephone').val();
    let email = $('#email').val();
    let _token = $("input[name=_token]").val();
    $.ajax({
        type: "POST",
        url: "/Admin/Etudiant/update",
        data: {
            id: id,
            matricule: matricule,
            noms: noms,
            telephone: telephone,
            email: email,
            _token: _token
        },
        success: function (response) {
            $('#sid' + response.etudiant.id + ' td:nth-child(2)').text(response.etudiant.noms)
            $('#sid' + response.etudiant.id + ' td:nth-child(3)').text(response.etudiant.matricule)
            $('#editEtudiantModal').modal('toggle')
            $('#editEtudiantForm')[0].reset()
        }
    });

});
