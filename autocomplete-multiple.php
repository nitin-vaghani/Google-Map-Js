<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://maps.googleapis.com/maps/api/js?key=KEY&libraries=places" async defer></script>
    </head>
    <body>
        <h2>This is multiple autocomplete google API demo in same page</h2>
        <div class="col-sm-12 form-group">
            <label for="th_location">Please select Location 1</label>
            <input type="text" placeholder="Enter location name" name="th_location[]" class="form-control required autocomplete" required="" maxlength="100" id="autocomplete_0">
            <input type="text" name="latitude" value="23.4566"/>
            <input type="text" name="longitude" value="72.6546556"/>
        </div>
        <div class="col-sm-12 form-group">
            <label for="th_location">Please select Location 2</label>
            <input type="text" placeholder="Enter location name" name="th_location[]" class="form-control required autocomplete" required="" maxlength="100" id="autocomplete_1">
            <input type="text" name="latitude" value="23.4566"/>
            <input type="text" name="longitude" value="72.6546556"/>
        </div>
    </body>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            var inputs = document.getElementsByClassName('autocomplete');

            var options = {
                types: ['geocode'],
            };

            var autocompletes = [];

            for (var i = 0; i < inputs.length; i++) {
                var autocomplete = new google.maps.places.Autocomplete(inputs[i], options);
                autocomplete.inputId = inputs[i].id;
                autocomplete.setFields(['geometry']);
                autocomplete.addListener('place_changed', fillIn);
                autocompletes.push(autocomplete);
            }

            function fillIn() {
                var selected_auto_id = this.inputId;
                var place = this.getPlace();
                var lat = place.geometry.location.lat(),
                        lng = place.geometry.location.lng();

                if (lat != "" && lng != "") {
                    $('#' + selected_auto_id).parent().find('input[name=latitude]:first').val(lat);
                    $('#' + selected_auto_id).parent().find('input[name=longitude]:first').val(lng);
                }
            }
        });
    </script>
</html>
