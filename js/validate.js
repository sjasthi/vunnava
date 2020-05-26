$(function() {
                $("input,textarea,select,file,password").jqBootstrapValidation(
                    {
                        preventSubmit: true,
                        submitError: function($form, event, errors) {
                            // Here I do nothing, but you could do something like display 
                            // the error messages to the user, log, etc.
                        },
                        submitSuccess: function($form, event) {
                            
                        },
                        filter: function() {
                            return $(this).is(":visible");
                        }
                    }
                );

                $("a[data-toggle=\"tab\"]").click(function(e) {
                    e.preventDefault();
                    $(this).tab("show");
                });

            });