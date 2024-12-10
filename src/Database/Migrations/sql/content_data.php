<?php

return <<<SQL

INSERT INTO contentnodes (id,content,parent,value,properties,type,weigth) VALUES
	 ('1bccc7b7-94bb-4384-ab97-24093bb71a01','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,'Hello world!','{}','h1',100),
	 ('ec6b9ea6-d971-426c-9cd2-c76d27398b3a','df056abc-dca6-41b1-9662-6b3b47e583ca','049c355c-7d6b-4354-9690-48e72edd56e0',NULL,'{}','text',100),
	 ('9e433cf7-8645-452c-bab5-592b5bb33fa3','df056abc-dca6-41b1-9662-6b3b47e583ca','ec6b9ea6-d971-426c-9cd2-c76d27398b3a','sit amet consectetur','{}','item',100),
	 ('45a6ba9e-b3ef-4f74-994e-1e932c0115a0','df056abc-dca6-41b1-9662-6b3b47e583ca','ec6b9ea6-d971-426c-9cd2-c76d27398b3a','lorem ipsum dolor','{}','item',90),
	 ('4206ea2d-380f-4e83-a5df-59ccd3a5c3be','df056abc-dca6-41b1-9662-6b3b47e583ca','ec6b9ea6-d971-426c-9cd2-c76d27398b3a','https://picsum.photos/200/300','{}','img',100),
	 ('818a24df-230c-42f1-9823-6b43746d5df8','6eee6539-7743-4b18-b70a-b9121d801783',NULL,'Consectetur adipiscing elit!','{}','h1',100),
	 ('b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87','df056abc-dca6-41b1-9662-6b3b47e583ca','a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb',NULL,'{}','ul',100),
	 ('abc56ea7-b014-409c-b724-1be0d7191fbc','df056abc-dca6-41b1-9662-6b3b47e583ca','b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87','lorem ipsum dolor','{}','item',100),
	 ('db85a32e-b50e-4c72-8ce5-5b38dd702a19','df056abc-dca6-41b1-9662-6b3b47e583ca','b5dd35c0-a18b-41b6-8af4-9ddeb0eb7f87','sit amet consectetur','{}','item',100),
	 ('a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,NULL,'{}','container',100),
	 ('53afa943-ed66-44c6-a94b-3730877f54fe','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,'<h1>Hello world!</h1>
<div>
	<div class="text">
		<p>lorem ipsum dolor</p>
		<p>sit amet consectetur</p>
		<p><img src="https://picsum.photos/200/300"></p>
	</div>
	<ul>
		<li>lorem ipsum dolor</li>
		<li>sit amet consectetur</li>
	</ul>
</div>','{}','code-plain',100),
	 ('049c355c-7d6b-4354-9690-48e72edd56e0','df056abc-dca6-41b1-9662-6b3b47e583ca','a4ce0b7a-5d1f-4a49-85f7-41cbfb0dd6fb',NULL,'{}','container',100),
	 ('82cd5a12-c6e4-4b3d-b5d3-b0e73d60865d','df056abc-dca6-41b1-9662-6b3b47e583ca','4f1ffe71-cdde-49de-8f7b-8b23ac7f9af8','A level 2 heading','{}','h2',100),
	 ('4f1ffe71-cdde-49de-8f7b-8b23ac7f9af8','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,NULL,'{}','container',100),
	 ('030f80a5-bdef-44e7-9f84-fb8563a8e050','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,NULL,'{"listType":"I"}','ol',100),
	 ('dc842927-3e69-4515-b3a8-c05417bdc2f0','df056abc-dca6-41b1-9662-6b3b47e583ca','030f80a5-bdef-44e7-9f84-fb8563a8e050','lorem','{}','item',100),
	 ('afd9253c-2234-47ee-88d0-7f978568e5c4','df056abc-dca6-41b1-9662-6b3b47e583ca','030f80a5-bdef-44e7-9f84-fb8563a8e050','ipsum','{}','item',100),
	 ('1169c2c0-f071-40a0-8f08-5a410aa1fea0','df056abc-dca6-41b1-9662-6b3b47e583ca','030f80a5-bdef-44e7-9f84-fb8563a8e050','dolor','{}','item',100),
	 ('bcfd6865-3c55-4e26-acff-493a413a44c2','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,NULL,'{}','table',100),
	 ('b3c2ba84-dec5-4458-91bd-9a08413278d3','df056abc-dca6-41b1-9662-6b3b47e583ca','9fc45f27-6d83-4ff9-8ccc-865bc85ed65c','value 1.1','{}','cell',50),
	 ('5850ae47-d049-4745-b4c2-74a038c7d889','df056abc-dca6-41b1-9662-6b3b47e583ca','9fc45f27-6d83-4ff9-8ccc-865bc85ed65c','value 1.2','{}','cell',100),
	 ('b8216a10-8476-4802-b6c4-9bfb31dbfba9','df056abc-dca6-41b1-9662-6b3b47e583ca','e3551475-7ab9-4762-9b37-9c35c935ce8b','value 2.1','{}','cell',50),
	 ('22deb290-de7f-41f9-bda9-169d465f678b','df056abc-dca6-41b1-9662-6b3b47e583ca','e3551475-7ab9-4762-9b37-9c35c935ce8b','value 2.2','{}','cell',100),
	 ('9fc45f27-6d83-4ff9-8ccc-865bc85ed65c','df056abc-dca6-41b1-9662-6b3b47e583ca','bcfd6865-3c55-4e26-acff-493a413a44c2',NULL,'{}','row',50),
	 ('e3551475-7ab9-4762-9b37-9c35c935ce8b','df056abc-dca6-41b1-9662-6b3b47e583ca','bcfd6865-3c55-4e26-acff-493a413a44c2',NULL,'{}','row',100),
	 ('1b5fdfec-0060-4497-ba15-1ce31a910b38','df056abc-dca6-41b1-9662-6b3b47e583ca','9cf6f60a-520f-4e3a-85e9-a2779af1a502','Heading 1','{}','table-heading',50),
	 ('7eeb89bd-9f11-4a4e-8154-8751bcb321a9','df056abc-dca6-41b1-9662-6b3b47e583ca','9cf6f60a-520f-4e3a-85e9-a2779af1a502','Heading 2','{}','table-heading',100),
	 ('9cf6f60a-520f-4e3a-85e9-a2779af1a502','df056abc-dca6-41b1-9662-6b3b47e583ca','bcfd6865-3c55-4e26-acff-493a413a44c2',NULL,'{}','row',25),
	 ('6f91c4c7-faf8-4fe5-88a6-65f21ed3d71c','df056abc-dca6-41b1-9662-6b3b47e583ca',NULL,'main-nav','{
	"template": "templates/nav-template.php"
}','collection',100);

SQL;