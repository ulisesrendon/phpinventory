/*
-Remove items
-Create new items
-Update content from items
-Update items position
*/
const SelectedNodeState = {
    id: 0,
    title: "",
    config: "",
    field_id: 0,
    description: ""
};

/**
 * @const {Object[]} ContentNodes
 */
ContentNodes ??= [];

document.addEventListener('DOMContentLoaded', async function()
{

    document.querySelector('#result').value = js_beautify(JSON.stringify(ContentNodes));
    
    const CustomHyperNode = new HyperNode({
        CustomHyperNode: [
            function(Item){
                
            }
        ]
    });

    ContentNodes.forEach(Item => {
        CustomHyperNode.addNode(Item);
    });

    // Schema container must be sortable and must have data-id="0" as attribute
    const TreeRoot = treeBasePrepare(document.querySelector('#treeBase'));
    const nodeMap = treeNodeRender(ContentNodes, TreeRoot);

});