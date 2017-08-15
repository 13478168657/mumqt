<?php
return [ 
		'oldhouseRentUrl' => [ 
				'hosts' => ['192.168.1.85:9200'],
				'index' => [ 
						'hr1',
						'hr2',
						'hr3',
						'hr4',
						'hr5',
						'hr6',
						'hr7' 
				],
				'type' => 't3' 
		],
		'oldhouseSaleUrl' => [ 
				'hosts' => ['192.168.1.85:9200'],
				'index' => [ 
						'hs1',
						'hs2',
						'hs3',
						'hs4',
						'hs5',
						'hs6',
						'hs7' 
				],
				'type' => 't3' 
		],
		'communityUrl' => [ 
				'hosts' => [ 
						'192.168.1.37:9200',
						'192.168.1.38:9200' 
				],
				'index' => 'sofangnewcommunity',
				'type' => 'external' 
		],
		'oldCommunityUrl' => [
				'hosts' => [
						'192.168.1.37:9200',
						'192.168.1.38:9200'
				],
				'index' => 'sofangoldcommunity',
				'type' => 'external'
		],
		'brokerUrl' => [
				'hosts' => [
						'192.168.1.37:9200',
						'192.168.1.38:9200'
				],
				'index' => 'sofangbroker',
				'type' => 'external'
		],
		'newhouseSaleUrl' => [
				'hosts' => [
						'192.168.1.37:9200',
						'192.168.1.38:9200'
				],
				'index' => 'sofangnewhousesale',
				'type' => 'external'
		],
		
		'houseRentUrl_old' => 'http://192.168.1.37:9200/sofangoldhouserent/',
		'houseSaleUrl_old' => 'http://192.168.1.37:9200/sofangoldhouserent/',
		'communityUrl_old' => 'http://192.168.1.89:9200/sofang/' 
];