<!DOCTYPE html>
<html>
    <head>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
        <meta charset="UTF-8">
        <title>Drawing Tools</title>
        <script type="text/javascript"  src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.js"></script>
        <script type="text/javascript"  src="http://maps.google.com/maps/api/js?sensor=false&key=AIzaSyDLP3AvJLqSmBujhoI_1Mg6Hvtd1RiuVsc&libraries=drawing"></script>
        <style type="text/css">
            #map, html, body {
                padding: 0;
                margin: 0;
                height: 100%;
            }
            #panel {
                width: 200px;
                font-family: Arial, sans-serif;
                font-size: 13px;
                float: right;
                margin: 10px;
            }
            #color-palette {
                clear: both;
            }
            .color-button {
                width: 14px;
                height: 14px;
                font-size: 0;
                margin: 2px;
                float: left;
                cursor: pointer;
            }
            #delete-button {
                margin-top: 5px;
            }
            #map_canvas {
                height: 100%;
                width: 100%;
                margin: 0px;
                padding: 0px
            }

        </style>
        <script type="text/javascript">
            var geocoder;
            var map;
            var all_overlays = [];

            function initialize() {
                var map = new google.maps.Map(
                        document.getElementById("map_canvas"), {
                    center: new google.maps.LatLng(37.4419, -122.1419),
                    zoom: 13,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var polyOptions = {
                    strokeWeight: 0,
                    fillOpacity: 0.45,
                    editable: true,
                    fillColor: '#FF1493'
                };
                var selectedShape;

                var drawingManager = new google.maps.drawing.DrawingManager({
                    drawingMode: google.maps.drawing.OverlayType.POLYGON,
                    drawingControl: false,
                    markerOptions: {
                        draggable: true
                    },
                    polygonOptions: polyOptions
                });

                $('#enablePolygon').click(function () {
                    drawingManager.setMap(map);
                    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);
                });

                $('#resetPolygon').click(function () {
                    if (selectedShape) {
                        selectedShape.setMap(null);
                    }
                    drawingManager.setMap(null);
                    $('#showonPolygon').hide();
                    $('#resetPolygon').hide();
                });

                google.maps.event.addListener(drawingManager, 'polygoncomplete',
                        function (polygon) {
                            //  var area = google.maps.geometry.spherical.computeArea(selectedShape.getPath());
                            //  $('#areaPolygon').html(area.toFixed(2)+' Sq meters');
                            $('#resetPolygon').show();
                        });

                function clearSelection() {
                    if (selectedShape) {
                        selectedShape.setEditable(false);
                        selectedShape = null;
                    }
                }


                function setSelection(shape) {
                    clearSelection();
                    selectedShape = shape;
                    shape.setEditable(true);
                }

                google.maps.event.addListener(drawingManager, 'overlaycomplete', function (e) {
                    all_overlays.push(e);
                    if (e.type != google.maps.drawing.OverlayType.MARKER) {
                        // Switch back to non-drawing mode after drawing a shape.
                        drawingManager.setDrawingMode(null);

                        // Add an event listener that selects the newly-drawn shape when the user
                        // mouses down on it.
                        var newShape = e.overlay;
                        newShape.type = e.type;
                        google.maps.event.addListener(newShape, 'click', function () {
                            setSelection(newShape);
                        });
                        setSelection(newShape);
                    }
                });

                google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
                    var coordinates = (polygon.getPath().getArray());
                    console.log(coordinates);
                    alert(coordinates);
                });
            }
            google.maps.event.addDomListener(window, "load", initialize);
        </script>
    </head>
    <body>
        <input type="button" id="enablePolygon" value="Calculate Area" />
        <input type="button" id="resetPolygon" value="Reset" style="display: none;" />
        <div id="showonPolygon" style="display:none;"><b>Area:</b> <span 
                id="areaPolygon">&nbsp;</span></div>
        <div id="map_canvas"></div>
</html>
