function init_register_user_controller(app_root_url, user_id, plugin, controller, missing_aco_text){
	//var url = app_root_url + "acl/admin_users/get_user_controller_permission/" + role_id + "/plugin:" + plugin + "/controller:" + controller;
	var url = app_root_url + "acl/admin_users/get_user_controller_permission/" + "?user_id=" + user_id + "&plugin=" + plugin + "&controller=" + controller;

	$.ajax({	url: url,
				dataType: "html",
				cache: false,
				success: function (data, textStatus)
				{
					//alert(data);
					permissions = jQuery.parseJSON(data);
					//alert(permissions);

					for(var action in permissions)
					{
						var start_granted = false;
						var span_id       = "right_" + plugin + "_" + user_id + "_" + controller + "_" + action;

						if(permissions[action] == true || permissions[action] == false)
						{
							if(permissions[action] == true)
							{
								icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/tick.png"  + "\" class=\"pointer\" alt=\"granted\" />";
								start_granted = true;
							}
							else
							{
								icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/cross.png"  + "\" class=\"pointer\" alt=\"denied\" />";
								start_granted = false;
							}

							$("#" + span_id).html(icon_html);

							register_user_toggle_right(start_granted, app_root_url, span_id, user_id, plugin, controller, action);
						}
						else
						{
							icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/important16.png"  + "\" alt=\"" + missing_aco_text + "\" title=\"" + missing_aco_text + "\" />";

							$("#" + span_id).html(icon_html);
						}
					}
				}
			});
}

function register_user(start_granted, app_root_url, span_id, user_id, plugin, controller, action){
}

function init_register_role_controller(app_root_url, role_id, plugin, controller, missing_aco_text){
	//var url = app_root_url + "acl/admin_users/get_role_controller_permission/" + role_id + "/plugin:" + plugin + "/controller:" + controller;
	var url = app_root_url + "acl/admin_users/get_role_controller_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller;

	$.ajax({	url: url,
				dataType: "html",
				cache: false,
				success: function (data, textStatus) {
					//alert(data);
					permissions = jQuery.parseJSON(data);
					//alert(permissions);

					for (var action in permissions) {
						var start_granted = false;
						var span_id       = "right_" + plugin + "_" + role_id + "_" + controller + "_" + action;

						if (permissions[action] == true || permissions[action] == false) {
							if (permissions[action] == true) {
								icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/tick.png"  + "\" class=\"pointer\" alt=\"granted\" />";
								start_granted = true;
							} else {
								icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/cross.png"  + "\" class=\"pointer\" alt=\"denied\" />";
								start_granted = false;
							}
							$("#" + span_id).html(icon_html);

							register_role(start_granted, app_root_url, span_id, role_id, plugin, controller, action);
						} else {
							icon_html = "<img src=\"" + app_root_url + "/web/img/admin/acl/important16.png"  + "\" alt=\"" + missing_aco_text + "\" title=\"" + missing_aco_text + "\" />";

							$("#" + span_id).html(icon_html);
						}
					}
				}
			});
}

function register_role(start_granted, app_root_url, span_id, role_id, plugin, controller, action){
	if (start_granted) {
		//var url = app_root_url + "acl/admin_users/get_role_controller_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller;
		var url1 = app_root_url + "acl/admin_users/deny_role_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller + "&action=" + action;
		var url2 = app_root_url + "acl/admin_users/grant_role_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller + "&action=" + action;
	} else {
		var url1 = app_root_url + "acl/admin_users/grant_role_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller + "&action=" + action;
		var url2 = app_root_url + "acl/admin_users/deny_role_permission/" + "?role_id=" + role_id + "&plugin=" + plugin + "&controller=" + controller + "&action=" + action;
	}

	$("#" + span_id).toggle(function()
                    		{
								$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action + "_spinner").show();

								$.ajax({	url: url1,
											dataType: "html",
											cache: false,
    										success: function (data, textStatus)
    										{
    											$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action).html(data);
    										},
    										complete: function()
        									{
        										$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action + "_spinner").hide();
        									}
										});
                    		},
                    		function()
                    		{
                    			$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action + "_spinner").show();

                    			$.ajax({	url: url2,
        									dataType: "html",
        									cache: false,
        									success: function (data, textStatus)
        									{
        										$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action).html(data);
        									},
        									complete: function()
        									{
        										$("#right_" + plugin + "_" + role_id + "_" + controller + "_" + action + "_spinner").hide();
        									}
								});
                    		});
}

