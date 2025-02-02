/*
 * Ext JS Library 2.0 Beta 1
 * Copyright(c) 2006-2007, Ext JS, LLC.
 * licensing@extjs.com
 * 
 * http://extjs.com/license
 */

Ext.onReady(function(){
    var win;
    var button = Ext.get('show-btn');

    button.on('click', function(){
        // create the window on the first click and reuse on subsequent clicks
        if(!win){
            win = new Ext.Window({
                el:'hello-win',
                layout:'fit',
                width:730,
                height:480,
                closeAction:'hide',
                plain: true,
                
                items: new Ext.TabPanel({
                    el: 'hello-tabs',
                    autoTabs:true,
                    activeTab:0,
                    deferredRender:false,
                    border:false
                }),
		    
                buttons: [
			/*
			  {
                    text:'Submit',
                    disabled:true
                    }, 

			  {
                    text: 'Close',
                    	handler: function(){
                    	win.hide();
                    	}
                	  }
			*/
			  ]
            });
        }
        win.show(this);
    });
});