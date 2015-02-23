jQuery( document ).ready( function () {
    tinymce.PluginManager.add('ez_portfolio_button', function( editor, url ) {
		editor.addButton( 'ez_portfolio_button', {
		selector: "textarea",
		toolbar: "ez_portfolio-button",
		icon: 'icon ez_portfolio-icon',
        onclick: function() {
			editor.windowManager.open( {
			title: 'EZ Portfolio Shortcode Menu',
            body: [
			{
                    type: 'listbox', 
                    name: 'effect', 
                    label: 'Hover Effect', 
                    'values': [
                        {text: 'Plain & Simple', value: 'simple'},
						{text: 'Classic', value: 'classic'},
                        {text: 'Push', value: 'push'},
                        {text: 'Door Classic', value: 'door-classic'}
                    ]
                },
                {
                    type: 'listbox', 
                    name: 'columns', 
                    label: 'Columns', 
                    'values': [
                        {text: '2 columns', value: '2'},
                        {text: '3 columns', value: '3'},
                        {text: '4 columns', value: '4'},
						{text: '5 columns', value: '5'},
						{text: '6 columns', value: '6'}
                    ]
                },
                {
                    type: 'listbox', 
                    name: 'items', 
                    label: 'Items', 
                    'values': [
                        {text: 'Show All', value: '-1'},
						{text: 'Show 3 items', value: '3'},
                        {text: 'Show 4 items', value: '4'},
                        {text: 'Show 5 items', value: '5'},
						{text: 'Show 6 items', value: '6'},
                        {text: 'Show 8 items', value: '8'},
						{text: 'Show 10 items', value: '10'}
                    ]
                }],
                onsubmit: function( e ) {
					editor.insertContent( '[ez-portfolio' + ' effect="' + e.data.effect + '"' + ' columns="' + e.data.columns + '"' + ' items="' + e.data.items + '"' + ']');
                    }
                });
            }
        });
    });	
});