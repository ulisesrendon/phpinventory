const getContentList = async function(){
    const response = await fetch(`${API_URL}/content`);
    const {list} = await response.json();
    return list ?? [];
};

document.addEventListener('DOMContentLoaded', async function(){

    const contentListContainer = document.querySelector(".render-content-list");
    const contentList = await getContentList();
    contentList.forEach(function(content){
        const item = document.createElement("li");
        item.innerHTML = `
                <div>
                    <a href="content-editor.html?id=${content.id}" class="block-anchor">${content.id} - ${content.title}</a>
                </div>
                <div><a href="content-editor.html?id=${content.id}">Update</a></div>
        `;
        contentListContainer.appendChild(item);
    });
});