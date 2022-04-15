
// Merci Pierre si tu passes par là pour ton aide sur Ajax et tout ce que tu nous as montré 
// (et laissé sur l'IDE)

/* Barre de recherche site => pour products et user
 Si c'est un product => img loupe à côté du nom du produit + lien vers productDetail
 Si c'est un user => img user par défaut + lien vers page des annonces du user en question
*/

const input = document.getElementById('search');
// voir pour créer le <ul> en JS et non en html
const search = document.getElementById('list-search');

input.addEventListener('keyup', (e) => {
    let value = e.target.value
    
    deleteOldQuery()
    query(value)
    .then(data => data.json())
    .then(data => {
        //console.log(data)
        if(value !== "") {
            for (let i = 0; i < data.length; i++) {
                let li = document.createElement('li');
                search.appendChild(li);
                li.innerHTML = 
                `<a href="https://yunacharlon.sites.3wa.io/lebonff/index.php?url=product&id=${data[i].id}">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    ${data[i].name}
                </a>`
            }
        }
    })
})

const query = async (value) => {
    return await fetch(`https://yunacharlon.sites.3wa.io/lebonff/index.php?url=search&q=${value}`);
}

function deleteOldQuery() {
    let item = search.children
    
    for(let i = item.length - 1; i >= 0; i--) {
        item[i].remove();
    }
}

// FRONT A FAIRE EN JS POUR LES RESULTATS DE LA RECHERCHE !