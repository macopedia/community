<?php

class Tx_Community_Service_Access_SimpleActionResourceMapper {

	/**
	 * @param array $oldMapping
	 * @return array 
	 */
	public function doMapping($oldMapping) {
		return array(
			'Message' => array(
				//'inbox' => 'message.inbox',
				//'outbox' => 'message.outbox',
				//'unread' => 'message.unread',
				//'read' => 'message.read',
				//'delete' => 'message.delete',
				'write' => 'message.write',
				'send' => 'message.write',
			),
			'User' => array(
				'image' => 'profile.image',
				'edit' => 'profile.edit',
				'search' => 'user.search',
				'searchBox' => 'user.searchBox',
				'update' => 'profile.edit',
				'details' => 'profile.details',
				'interaction' => 'profile.menu',
				'editImage' => 'profile.edit.image',
				'addToWatchlist' => 'profile.watchlist',
				'removeFromWatchlist' => 'profile.watchlist',
				'report' => 'profile.report',
			),
			'Relation' => array(
				'listSome' => 'profile.relation.listSome',
				'list' => 'profile.relation.list',
				'request' => 'profile.relation.request',
				'confirm' => 'profile.relation.confirm',
				'reject' => 'profile.relation.reject',
				'unconfirmed' => 'profile.relation.unconfirmed',
				'cancel' => 'profile.relation.cancel',
			),
			'WallPost' => array(
				'list' => 'profile.wall.list',
				'new' => 'profile.wall.write',
				'create' => 'profile.wall.write',
			),
			'Album' => array(
				'list' => 'profile.gallery',
				'show' => 'profile.gallery',
			),
			'Photo' => array(
				'avatar' => 'profile.gallery.avatar',
					//allows seting other user's photo as avatar
					//but still need to be able to see the photo
			),
			'Utils' => array(
				'flashMessagesDisplay' => 'utils'
			)
		);
	}

}
?>
