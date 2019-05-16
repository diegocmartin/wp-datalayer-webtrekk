 jQuery( document ).ready( function( $ ) {
    var LD_Zapier = {
        init: function() {
            this.toggle();
        },
        toggle: function() {
            var $events = {
                'course': [ 
                    'enrolled_into_course',
                    'course_completed',
                ],
                'lesson': [
                    'lesson_completed',
                ],
                'topic': [
                    'topic_completed',
                ],
                'quiz': [
                    'quiz_passed',
                    'quiz_failed',
                    'quiz_completed',
                ],
            };

            $.each( $events, function( $index, $array ) {
                $( '.zapier_trigger' ).change( function( e ) {
                    var $value = $( this ).val();
                    if ( $.inArray( $value, $array ) != -1 ) {
                        $( '.zapier_trigger_' + $index ).show();
                    } else {
                        $( '.zapier_trigger_' + $index ).hide();
                    }
                } );  

                $( window ).load( function() {
                    var $value = $( '.zapier_trigger' ).val();
                    if ( $.inArray( $value, $array ) != -1 ) {
                        $( '.zapier_trigger_' + $index ).show();
                    } else {
                        $( '.zapier_trigger_' + $index ).hide();
                    }
                } );   
            } );
        },
    };

    LD_Zapier.init();
} );