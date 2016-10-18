window.digirisk.tools = {};

window.digirisk.tools.init = function() {
	window.digirisk.tools.event();
};

window.digirisk.tools.event = function() {
	jQuery( document ).on( 'click', '.digi-tools-main-container .nav-tab', window.digirisk.tools.tab_switcher );
	jQuery( document ).on( 'click', '.reset-method-evaluation', window.digirisk.tools.reset_evaluation_method );
	jQuery( document ).on( 'click', '.element-risk-compilation', window.digirisk.tools.risk_fixer );
};

window.digirisk.tools.tab_switcher = function( event ) {
  event.preventDefault();

  /**	Remove all calss active on all tabs	*/
  jQuery( this ).closest( "h2" ).children( ".nav-tab" ).each( function(){
	  jQuery( this ).removeClass( "nav-tab-active" );
  });
  /**	Add the active class on clicked tab	*/
  jQuery( this ).addClass( "nav-tab-active" );

  /**	Hide the different container and display the selected container	*/
  jQuery( this ).closest( ".digi-tools-main-container" ).children( "div" ).each( function(){
	  jQuery( this ).hide();
  });
  jQuery( "#" + jQuery( this ).attr( "data-id" ) ).show();
},

window.digirisk.tools.reset_evaluation_method = function( event ) {
  event.preventDefault();

  if ( window.confirm( window.digi_tools_confirm ) ) {
    jQuery( this ).addClass( "wp-digi-loading" );
    jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

    var li = document.createElement( 'li' );
    li.innerHTML = window.digi_tools_in_progress;
    jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

    var data = {
      action: 'reset_method_evaluation',
      _wpnonce: jQuery( this ).data( 'nonce' )
    };

		window.digirisk.tools.exec_request( li, data, this );
  }
},

window.digirisk.tools.risk_fixer = function( event ) {
  event.preventDefault();

  jQuery( this ).addClass( "wp-digi-loading" );
  jQuery( this ).closest( 'div' ).find( 'ul' ).html('');

  var li = document.createElement( 'li' );
  li.innerHTML = window.digi_tools_in_progress;
  jQuery( this ).closest( 'div' ).find( 'ul' ).append( li );

  var data = {
    action: 'compil_risk_list',
    _wpnonce: jQuery( this ).data( 'nonce' )
  };

  window.digirisk.tools.exec_request( li, data, this );
},

window.digirisk.tools.exec_request = function( li, data, element ) {
	jQuery.post( window.ajaxurl, data, function() {
		jQuery( element ).removeClass( "wp-digi-loading" );
		li.innerHTML += ' ' + window.digi_tools_done;
	} );
}
