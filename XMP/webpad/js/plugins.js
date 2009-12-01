/********************************************************************\
  These functions are provided to give plugin developers the ability
  to add and remove tools to/from the toolbar on the plugins dialog.
  
  You cannot modify the left-most (change plugin) tool, which is 
  provided by the system, so it stays there.
\********************************************************************/

// Add a tool to the plugins toolbar.
// icon		must be a 25 x 25px transparent gif, with a matte done to
// 			match the background color. Provide a path, not just an
// 			image name, so it might be '../plugins/myplugin/tool.gif'
//
// href		is the link to be applied to the tool
//
// tooltip	is the "title" attribute to be used.
//
// position	is a number from 1 - 3 representing the location in the list to put it.
//
/**
 * @return void
 * @param String icon
 * @param String href
 * @param String tooltip
 * @param Int position
 * @desc Adds a tool to the plugin toolbar. Icon should be the path to
 *       an icon, and it should be a 25x25px transparent gif. href is the
 *       link to point to, tooltip is the title attribute and position
 *       indicates where in the toolbar it should appear (1 = left, 3 = right)
 */
function add_plugin_tool(icon, href, tooltip, position) {
	if (!icon.length || !href.length || !tooltip.length || !position) {
		return;
	}
	remove_plugin_tool(position);
	ph = parent.document.getElementById('tool' + position);
	str = '<a href="' + href + '" title="' + tooltip + '"><img src="' + icon + '" width="25" height="25" border="0" /></a>';
	ph.innerHTML = str;
}

/**
 * @return void
 * @param Int position
 * @desc Remove a single tool from the toolbar plugin, based on postion
 */
function remove_plugin_tool(position) {
	parent.document.getElementById('tool' + position).innerHTML = '';
}

/**
 * @return void
 * @desc Removes all user-added tools from the plugin menu
 */
function clear_plugin_tools() {
	remove_plugin_tool(1);
	remove_plugin_tool(2);
	remove_plugin_tool(3);
}