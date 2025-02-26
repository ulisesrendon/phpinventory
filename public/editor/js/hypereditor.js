function uuidV4() {
    const uuid = new Array(36);
    for (let i = 0; i < 36; i++) {
      uuid[i] = Math.floor(Math.random() * 16);
    }
    uuid[14] = 4; // set bits 12-15 of time-high-and-version to 0100
    uuid[19] = uuid[19] &= ~(1 << 2); // set bit 6 of clock-seq-and-reserved to zero
    uuid[19] = uuid[19] |= (1 << 3); // set bit 7 of clock-seq-and-reserved to one
    uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';
    return uuid.map((x) => x.toString(16)).join('');
}

function eventChangeImplementation( element ){
	const evt = new Event('change');
    const observer = new window.MutationObserver(function (mutations, observer) {
        if (mutations[0].attributeName == "value") element.dispatchEvent(evt);
    });
    observer.observe(element, { attributes: true });
}

class HyperNode
{
    #events = [];
    #nodeMap = [];

    /**
     * @param {Object} Events 
     */
    constructor(Events)
    {
        this.#events = Events;
    }

    addNode(Item)
    {
        this.#nodeMap[Item.id] = Item;

        this.#events.CustomHyperNode.forEach((Event)=>Event(Item));
    }

    getNodes()
    {
        const nodes = [];
        for(let Item in this.#nodeMap){
            nodes.push(this.#nodeMap[Item]);
        }
        return nodes;
    }
}


const treeBasePrepare = function(treeBase){
    treeBase.setAttribute('data-id', 0);
    new Sortable(treeBase, {
        handle: '.handle',
        group: 'nested',
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.1
    });
    return treeBase;
};

const nodeItemBase = document.createElement('div');
nodeItemBase.classList.add('list-group-item');
nodeItemBase.classList.add('nested');
const nodeRender = function (node) {
    const newItem = nodeItemBase.cloneNode();
    newItem.setAttribute('data-id', node.id);
    newItem.classList.add('nodeitem');
    newItem.innerHTML = `
        <div class="handle">↕</div>
        <div>
            <h4>${node.type}</h4>
            <div class="form-field">
                <input type="text" class="form-field-block" value="${node.value}">
            </div>
        </div>
        <div class="nested-sortable" data-id="${node.id}"></div>
    `;
    new Sortable(newItem.querySelector('.nested-sortable'), {
        group: 'nested',
        handle: '.handle',
        animation: 150,
        fallbackOnBody: true,
        swapThreshold: 0.1
    });
    return newItem;
};

const addTreeNode = function (treeBase, nodeMap, nodeItem){
    nodeMap[nodeItem.id] = {
        "render": nodeRender(nodeItem),
        "data": nodeItem
    };
    treeBase.appendChild(nodeMap[nodeItem.id].render);
};

const treeNodeRender = function (nodeList, treeBase) {
    let nodeMap = [];
    for (let i = 0; i < nodeList.length; i++) {
        addTreeNode(treeBase, nodeMap, nodeList[i]);
    }
    for (id in nodeMap) {
        if (nodeMap[id].data.parent != 0 && nodeMap[nodeMap[id].data.parent]) {
            nodeMap[nodeMap[id].data.parent].render.querySelector('.nested-sortable').appendChild(nodeMap[id].render);
        }
    }

    return nodeMap;
};
