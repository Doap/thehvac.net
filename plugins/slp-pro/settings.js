jQuery(document).ready(function($) {
   jQuery('textarea[name="csl-slplus-lookup_address"]').change(
       function() {
            jQuery.get(
                'http://maps.googleapis.com/maps/api/geocode/json',
                {sensor:'false',
                 address:jQuery('textarea[name="csl-slplus-lookup_address"]').val()
                },
                function (response) {
                    try {
                        response = JSON.parse(response);
                    }
                    catch (ex) {
                    }
                    var location =
                            (typeof response.results[0] === 'undefined')         ?
                            ' could not be geocoded with Google'                :
                            response.results[0].geometry.location.lat + ',' +
                            response.results[0].geometry.location.lng;
                    var newText= "\n\n is at "+location;
                    jQuery('textarea[name="csl-slplus-lookup_address"]').val(
                        jQuery('textarea[name="csl-slplus-lookup_address"]').val() + newText
                    );
                }
            );
       }
   );
});
