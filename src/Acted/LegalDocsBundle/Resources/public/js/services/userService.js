;(function(window) {
	/**
	 * Service to get information about current user
	 */

	 window.userDataProvider = {
	 	types: ['ARTIST', 'CLIENT'],
	 	get: function() {
	 		return new Promise(function(resolve, reject) {
 				var user = localStorage.getItem('user');
 					user = JSON.parse(user);

				if (user) {
					resolve(user);
				}  else {
					reject({});
				}
			});
	 	},
	 	currentUser: function() {
	 		var self = this;

	 		return this.get()
	 		.then(function(user) {
	 			var type = self.getType(user.artistId);

	 			return {
	 				user: user,
	 				type: type 
	 			};
	 		})
	 		.catch(function(err) {
				return err;
	 		})
	 	},
		getType: function(t) {
			if( t ) { return this.types[0]; }
			return this.types[1];
		}
	 }

})(this);