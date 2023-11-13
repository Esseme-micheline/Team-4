var elementCounter = 1;

var Area_Btn = document.getElementById("buttonArea")


function add(){
    elementCounter += 1
    var ajout = document.getElementById("modelForm").cloneNode(true)
    var formulaire = document.getElementById("formContainType")
    var myFooter = document.getElementById("footerContainType")

    champLab=ajout.querySelector("input")
    champLabs=ajout.querySelector("#intitule")
    champTyp=ajout.querySelector("select")
    champLab.value = ""
    champLabs.value=""

    formulaire.appendChild(ajout);
    formulaire.appendChild(Area_Btn);
    formulaire.appendChild(myFooter);
}

function del(){
    if(elementCounter>1){
        var formulaire = document.getElementById("formContainType")
        var toDelete = formulaire.lastChild
        toDelete = toDelete.previousSibling
        toDelete = toDelete.previousSibling
        formulaire.removeChild(toDelete)
        elementCounter -=1
    }
    else{
        console.log("echec de suppression")
    }
}
