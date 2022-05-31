const input = document.getElementById('search');
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
