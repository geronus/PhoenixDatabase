Phoenix = {
	Data: { Ranks: [], Members: [], Areas: [], User: '' },
	Click: {
		Update: function() {
			$(this).addClass('updating');
			Phoenix.Popupholder = $('#popupholder');
			Phoenix.Popup = $('#popupholder #popup');
			Phoenix.Data.User = Phoenix.Get.LoggedInUser();
			
			Phoenix.Log.Clear();
			Phoenix.Log('Updating guild...');
			Phoenix.Get.Ranks();
		}
	},
	Show: {
		Holder: function() {
			Phoenix.Popupholder.css('visibility', 'visible');
		}
	},
	Log: (function() {
		log = function(msg) {
			Phoenix.Show.Holder();
			Phoenix.Popup.append('<p>'+ msg +'</p>');
		};
		log.Clear = function() {
			Phoenix.Popup.empty();
		};
		return log;
	})(),
	Get: {
		Members: function() {
			Phoenix.Log('Fetching member contributions...');
			$.post('https://lyrania.co.uk/guilds.php', {x: 4}).done(function(response) {
				$html = $('<div>'+ response +'</div>');
				if ($html.find('div b:contains(Phoenix)').length > 0) {
					Phoenix.Log('Ranks fetched, moving on...');
					Phoenix.Process.Members($html);
					Phoenix.Get.Areas();
				}
				else {
					Phoenix.Log('You are not in this guild.  Stopping update...');
				}
			});
		},
		Ranks: function() {
			Phoenix.Log('Fetching current member ranks...');
			$.post('https://lyrania.co.uk/guildrank.php', {x: 4, y: null, z: null}).done(function(response) {
				//console.log(response);
				Phoenix.Log('Ranks fetched, moving on...');
				Phoenix.Process.Ranks($('<div>'+ response +'</div>'));
				Phoenix.Get.Members();
			});
		},
		Areas: function() {
			Phoenix.Log('Fetching member\'s Areas...');
			$.post('https://lyrania.co.uk/commands.php', {x: 'guildwho'}).done(function(response) {
				Phoenix.Log('Areas fetched, moving on...');
				Phoenix.Process.Areas($('<div>'+ response +'</div>'));
				Phoenix.Post();
			});
		},
		LoggedInUser: function() {
			return $('#lvlli').parent().find('li:first').text();
		}
	},
	Process: {
		Ranks: function(html) {
			Phoenix.Data.Ranks = [];
			html.find('tr').each(function() {
				var name = $(this).find('td:first').text();
				var id = $(this).find('select').attr('id').replace('rank', '');
				var rank = $(this).find('select option:selected').text().match(/\[(.*)\]/);
				
				Phoenix.Data.Ranks.push({
					id: 	id, 
					name: 	name, 
					rank: 	(rank && rank.length ? rank[0].replace('[','').replace(']','') : 0)
				});
			});
		},
		Members: function(html) {
			Phoenix.Data.Members = [];
			html.find('a:contains([Quit Guild])').remove(); //don't want this link
			html.find('a:last').remove(); //don't want the back link either!
			
			html.find('a').each(function() {
				//console.log($(this));
				var name = $(this).attr('href').replace('javascript:visg("', '').replace('",1)', '');
				//console.log(name);
				Phoenix.Data.Members.push({
					name: 		name,
					details: 	html.find('#'+ name).text()
				});
			});
		},
		Areas: function(html) {
			Phoenix.Data.Areas = [];
			html.find('span').each(function() {
				var name = $(this).find('a:first').attr('href').replace('");', '').replace('javascript:whisper("', '');
				var arr = $(this).text().split(' Area: ')
				var arr = arr[1].split(' - ');
				var area = arr[0];
				Phoenix.Data.Areas.push({
					name: 	name,
					area: 	area
				});
			});
		}
	},
	Post: function() {
		Phoenix.Log('Posting stuff away to the DB...');
		$.post('https://phoenix.rtehl33t.net/guildsave-auto.php', Phoenix.Data).done(function(response) {
			if (response.status == 'ok') {
				console.log(response);
				Phoenix.Log('Phoenix guild was updated successfully');
				if (response.data.ranks.length > 0) {
					Phoenix.Popup.append('<br /><br />Unpaid GDP Milestones:<br />');
					html = '<table cellpadding=5 cellspacing=1 border=1 align="center"><tr><td>Member</td><td>New Rank</td><td>RN</td><td>Pay Due</td></tr>';
					for (var i=0; i<response.data.ranks.length; i++) {
						mem = response.data.ranks[i];
						html += '<tr><td>'+ mem.Name +'</td><td>'+ mem.num +'</td><td>'+ mem.rom +'</td><td>'+ mem.pay +'p</td></tr>';
					}
					Phoenix.Popup.append(html +'</table>');
				}
				Phoenix.Popupholder.css('visibility', 'visible');
			}
			else {
				Phoenix.Log('There was a problem updating database.  Contact iZarcon');
			}
		}).fail(function() {
			Phoenix.Log('There was a problem updating the database.  Please contact iZarcon');
		}).always(function() {
			$('#phoenix_update').removeClass('updating');
		});
	},
	Prep: function() {
		$('#phoenix_command').remove();
		//if ($('#phoenix_command').length == 0) {
			$('body').append('<div style="position: absolute; right: 0px; bottom: 0px; padding: 5px 10px;" id="phoenix_command"></div>');
			$('#phoenix_command').append('<input type="button" id="phoenix_update" value="Update Guild" />');
			$('#phoenix_update:not(.updating)').click(Phoenix.Click.Update);
		//}
	}
};