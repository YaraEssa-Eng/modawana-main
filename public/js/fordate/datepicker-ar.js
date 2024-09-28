/* Arabic Translation for jQuery UI date picker plugin. */  
/* Used in most of Arab countries, primarily in Bahrain, */  
/* Kuwait, Oman, Qatar, Saudi Arabia and the United Arab Emirates, Egypt, Sudan and Yemen. */  
/* Written by Mohammed Alshehri -- m@dralshehri.com */  

( function( factory ) {  
	"use strict";  

	if ( typeof define === "function" && define.amd ) {  

		// AMD. Register as an anonymous module.  
		define( [ "../widgets/datepicker" ], factory );  
	} else {  

		// Browser globals  
		factory( jQuery.datepicker );  
	}  
} )( function( datepicker ) {  
	"use strict";  

	datepicker.regional.ar = {  
		closeText: "إغلاق",  
		prevText: "السابق",  
		nextText: "التالي",  
		currentText: "اليوم",  
		monthNamesShort: [ "كانون الثاني", "شباط", "آذار", "نيسان", "أيار", "حزيران",  
			"تموز", "آب", "أيلول", "تشرين الأول", "تشرين الثاني", "كانون الأول" ],   
		// dayNamesMin: [ "الأحد", "الاثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة", "السبت" ],  
		dayNamesMin: [ "أحد", "اثنين", "ثلاثاء", "أربعاء", "خميس", "جمعة", "سبت" ],  
		// dayNamesMin: [ "ح", "ن", "ث", "ر", "خ", "ج", "س" ],  
		weekHeader: "أسبوع",  
		dateFormat: "dd/mm/yy",  
		firstDay: 0,  
		isRTL: true,  
		showMonthAfterYear: false,  
		yearSuffix: ""  
	};  
	datepicker.setDefaults( datepicker.regional.ar );  

	return datepicker.regional.ar;  

} );  