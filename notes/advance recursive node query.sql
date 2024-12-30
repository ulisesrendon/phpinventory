WITH RECURSIVE nodes as (
SELECT 
    id,
    content,
    parent,
    value,
    properties,
    weight,
    type
from contentnodes
where content = 'df056abc-dca6-41b1-9662-6b3b47e583ca'
UNION ALL
SELECT 
	offnodes.id,
    offnodes.content,
    offnodes.parent,
    offnodes.value,
    offnodes.properties,
    offnodes.weight,
    offnodes.type
FROM contentnodes offnodes
INNER JOIN nodes ON JSON_VALUE(nodes.properties, '$.layout') = offnodes.content
)
select 
nodes.*,
JSON_VALUE(properties, '$.layout') as layout,
JSON_VALUE(properties, '$.layoutContainer') as layoutContainer
from nodes
group by 
	id,
    content,
    parent,
    value,
    properties,
    weight,
    type
order by 
	content,
	parent,
	weight