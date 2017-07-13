<?php
	
//	// JavaScript control for deny enter text to an input box
//	define( "JS_BLOCK", " onKeypress=\"return false;\"" );
//
//	//	JavaScript control for Texts without spaces
//	define( "JS_PASSWD", " onKeypress=\"hkp(event); if ((_KeyCode < 32 && _KeyCode != 0 && _KeyCode != 8) || _KeyCode > 126) return false;\"" );
//
//	//	JavaScript control for Texts without spaces
//	define( "JS_ONLY_ALFA", " onKeyPress=\"hkp(event); if ( (_KeyCode < 96 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 32 && !(_KeyCode > 64 && _KeyCode < 91)) || _KeyCode > 123 ) return false;\"" );
//
//	//	JavaScript control for Texts without spaces
//	define( "JS_ONLY_ALFA_NOSPACES", " onKeypress=\"hkp(event); if ( (_KeyCode < 96 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 95 && !(_KeyCode > 64 && _KeyCode < 91)) || _KeyCode > 123 ) return false;\"" );
//
//	//	JavaScript control for Texts without spaces
//	define( "JS_ONLY_ALFA_WNUMS", " onKeypress=\"hkp(event);
//	if ( (_KeyCode < 96 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 95 && !(_KeyCode > 48 && _KeyCode < 58) && !(_KeyCode > 64 && _KeyCode < 91)) || _KeyCode > 123 ) return false;\"" );
//
//	//	JavaScript control for Texts without spaces
//	define( "JS_ONLY_ALFA_WNUMS_DOT_SLASH", " onKeypress=\"hkp(event);
//	if ( (_KeyCode < 96 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 95 && !(_KeyCode > 44 && _KeyCode < 58) && !(_KeyCode > 64 && _KeyCode < 91)) || _KeyCode > 123 ) return false;\"" );
//
	// JavaScript control for allow only digits in an input box
	define( "JS_ONLY_NUMS", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8) || _KeyCode > 57) return false;\"" );
    define( "JS_ONLY_NUMS_PUNTO", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 46) || _KeyCode > 57) return false;\"" );
//
//	// JavaScript control for allow only digits and dot char in an input box
//	define( "JS_ONLY_NUMS_WITH_DOT", " onKeypress=\"hkp(event); if ((_KeyCode < 46 && _KeyCode != 0 && _KeyCode != 8) || _KeyCode == 47 || _KeyCode > 57) return false;\"" );
//
//	// JavaScript control for allow only digits and 'minus' char in an input box
//	define( "JS_ONLY_NUMS_WITH_LINE", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 45) || _KeyCode > 57) return false;\"" );
//
//	// JavaScript control for allow only digits and space char in an input box
//	define( "JS_ONLY_NUMS_WITH_SPACE", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 32) || _KeyCode > 57) return false;\"" );
//
//	// JavaScript control for allow only digits and space and '[' and ']' chars in an input box
//	define( "JS_ONLY_NUMS_WITH_SPACE_CORCH", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8) || (_KeyCode > 57 && _KeyCode != 91 && _KeyCode != 93)) return false;\"" );
//
//	// JavaScript control for allow only digits and space and '(' and ')' chars in an input box
//	define( "JS_ONLY_NUMS_WITH_DOT_PAR", " onKeypress=\"hkp(event); if ((_KeyCode < 46 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 40 && _KeyCode != 41) || _KeyCode == 47 || _KeyCode > 57) return false;\"" );
//
//	// JavaScript control for confirm delete link
//	define( "JS_CONF_DELETE_INI", " onClick=\" return confirm('Confirme eliminar de:\\n\\n" );
//	define( "JS_CONF_DELETE_END", "')\"" );
//
//	//	JavaScript control for confirm session close
//	define( "JS_CONF_SESS_CLOSE", " onClick=\" return confirm('Confirme cerrar sesion')\"" );
//
//	//	JavaScript control for date fields
//	define( "JS_DATE", " onKeypress=\"hkp(event); if ((_KeyCode < 47 && _KeyCode != 0 && _KeyCode != 8) || _KeyCode > 57) return false;\"" );
//
//	//	JavaScript control for date fields
//	define( "JS_HOUR", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8) || _KeyCode > 58) return false;\"" );
//
//	//	JavaScript control for date fields
//	define( "JS_HOUR_RANGE", " onKeypress=\"hkp(event); if ((_KeyCode < 48 && _KeyCode != 0 && _KeyCode != 8 && _KeyCode != 45) || _KeyCode > 58) return false;\"" );
//
//	//	JavaScript code for calendar fields - INIT
//	define( "JS_CALENDAR_INI", "<a href=\"javascript:show_calendar('" );
//	define( "JS_CALENDAR_END", "');\"><img src=\"" . IMAGES_PATH . "admin/show-calendar.gif\" width=24 height=22 border=0 align=\"absmiddle\"></a>\n" );
?>