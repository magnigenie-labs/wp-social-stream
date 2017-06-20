jQuery(document).ready(function($){
    var count = 0,
	list = [],
	services = {};
	
	jQuery.each( users, function(svc,valueObj ){
		if( valueObj!='' && svc != 'num_feeds' && svc != 'google_api_svc'){
			if( svc == 'googleplus' ) {
				services = {
					service: svc,
					user: valueObj,
					key: users.google_api_key
				}
			}
			else if( svc == 'deviantart' ) {
				services = {
					service: svc,
					user: valueObj,
					template: {
						deviationpost: '<a href="http://'+valueObj+'.deviantart.com/">'+valueObj+'</a> uploaded a deviation: <a href="${url}">${title}</a>'
					}
				}
			}
			else {
				services = {
					service: svc,
					user: valueObj,
				}
			}
		list.push( services );
		}
	 });
      
console.log(list);
      Date.prototype.toISO8601 = function(date) {
          var pad = function (amount, width) {
              var padding = "";
              while (padding.length < width - 1 && amount < Math.pow(10, width - padding.length - 1))
                  padding += "0";
              return padding + amount.toString();
          }
          date = date ? date : new Date();
          var offset = date.getTimezoneOffset();
          return pad(date.getFullYear(), 4)
              + "-" + pad(date.getMonth() + 1, 2)
              + "-" + pad(date.getDate(), 2)
              + "T" + pad(date.getHours(), 2)
              + ":" + pad(date.getMinutes(), 2)
              + ":" + pad(date.getUTCSeconds(), 2)
              + (offset > 0 ? "-" : "+")
              + pad(Math.floor(Math.abs(offset) / 60), 2)
              + ":" + pad(Math.abs(offset) % 60, 2);
      };

      jQuery("#lifestream").lifestream({
        limit: parseInt(users.num_feeds),
        list: list,
        feedloaded: function(){
          count++;
          // Check if all the feeds have been loaded
          if( count === list.length - 1 ){
            jQuery("#lifestream li").each(function(){
              var element = $(this),
                  date = new Date(element.data("time"));
              element.append('<span class="timeago" title="' + date.toISO8601(date) + '">' + date + "</span>");
            })
            jQuery("#lifestream .timeago").timeago();
          }
        }
      });
});
