<?php require_once(TEMPLATE_PATH . 'header.include.php'); ?>
    <section class="content">
        <div class="box animated bounceInRight">
            <div class="box-header with-border">
                <h3 class="box-title">Proces Status <?php foreach ($results as $row) {
                        echo $row->getAanvraag->aanvraag_nr;
                    } ?></h3>
            </div>
            <div class="box-body">
                <form action="apps/<?php echo app_name; ?>/processtatus.php?action=aanvraag" method="post"
                      class="form-horizontal">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" class="search-query form-control" id="search" name="search"
                                       placeholder="Zoeken op... aanvraagnummer"/>
                                <input type="hidden" class="search-query form-control" value="aanvraag" id="type"
                                       name="type"/>
                                <span class="input-group-btn">
                                            <button class="btn btn-danger btnSearch" type="submit">
                                                <span class=" glyphicon glyphicon-search"></span>
                                            </button>
                                        </span>
                            </div>
                        </div>

                    </div>
                </form>


                <?php
                //$count = 1;
                /*                           foreach ($buitenAll as $r) {
                                               echo  $count ."</br>";
                                               echo $r->getAanvraag->aanvraag_nr."</br>";
                                               echo $r->getBuitenlandseInkoop->po_nr."</br>";
                                               echo $r->getBinnenlandseInkoop->id."</br>";
                                               echo $row->getAanvraag->bstl_aanvraag_datum;

                                               if (!empty($r->getBuitenlandseInkoop->id)) {
                                                   echo '<td>' . $r->getBuitenlandseInkoop->po_nr . '</td>
                                   <td>' . $r->getBuitenlandseInkoop->cof_nr . '</td>
                                   <td>' . $r->getBuitenlandseInkoop->afdeling . '</td>
                                   <td>' . $r->getBuitenlandseInkoop->leverancier_id . '</td>
                                   <td>' . $r->getBuitenlandseInkoop->valuta . ': ' . $r->bedrag . '</td>
                                   <td>' . $r->getBuitenlandseInkoop->authorisatienr . '</td>

                                               } else {
                                                  echo "test";
                                               }

                                               //$count++;
                                           }
               */
                ?>
                <?php

                $count = 1;
                foreach ($results as $row) {

                    //echo $row->getAanvraag->bstl_aanvraag_datum."</br>";
                    //    echo $row->getAanvraag->bstl_afdeling."</br>";
                    //   echo $row->getAanvraag->bstl_tbv."</br>";
                    //    echo $row->getUser->username."</br>";
                }
                $count++;

                ?>

                <body onload="init()">
                <div id="sample">
                    <h3></h3>
                    <div style="width:100%; white-space:nowrap;">
      <span style="display: inline-block; vertical-align: top; padding: 5px; width:80%">
      <div id="myDiagramDiv" style="border: solid 0px gray; background-color: #ffffff;  height: 768px;"></div>
    </span>
                    </div>
                    <p>

                        <button onclick="load()">Load</button>
                        Diagram Model saved in JSON format:
                        <textarea id="mySavedModel" name="hide" style="display:none;width:100%;height:300px">
{ "class": "go.GraphLinksModel",
  "linkFromPortIdProperty": "fromPort",
  "linkToPortIdProperty": "toPort",
  "nodeDataArray": [

{"key":-1, "category":"Start", "loc":"-123.99999999999997 19.000000000000007", "text":"Start"},
{"key":1,<?php if (empty($row->getAanvraag->aanvraag_nr)) {
                                echo '';
                            } else echo '"color":"red",'; ?> "loc":"49.99999999999994 19.000000000000014", "text":"Invoer bestelling"},
{"key":2, "loc":"270.0000000000001 19", "text":"Accoord Logistiek en H.Inv"},
{"key":3, "loc":"45.99999999999994 116.00000000000006", "text":"Inbehandeling"},
{"key":6, "loc":"279.9999999999999 275.0000000000002", "text":"Binnenland"},
{"key":7, "loc":"472.9999999999999 275.0000000000002", "text":"Opvraag offertes"},
{"key":8, "loc":"674.0000000000001 274.999999999999", "text":"Opmaak bestelbrief"},
{"text":"Soort aankoop", "figure":"Diamond", "key":-3, "loc":"288 116.25"},
{"text":"Buitenland", "key":-11, "loc":"518 116.25"},
{"text":"Opvraag offertes", "key":-12, "loc":"671 116.25"},
{"text":"Opmaak PO\n& betalingsopdracht", "key":-14, "loc":"859 116.25"},
{"text":"Goedkeuring \nHPROC (Paraaf)", "key":-15, "loc":"859 275.25"},
{"text":"Goedkeuring \naanvraag", "key":-16, "loc":"859 380.25"},
{"text":"Buitenland: Getekende PO Mailen voor leverancier", "key":-17, "loc":"655 380.25"},
{"text":"Binnenland: Getekende PO Mailen voor leverancier", "key":-18, "loc":"859 514.25"},
{"text":"   Betalings\nvoorwaarden", "figure":"Diamond", "key":-19, "loc":"421 376.25"},
{"text":"Verzend de bestelde items en Inklaringen", "key":-20, "loc":"417 540.25"},
{"text":"Aanvraag invoice aan de leverancier", "key":-21, "loc":"143 447.25"},
{"text":"Opmaak BO met Proforma invoice", "key":-22, "loc":"-177 448.25"},
{"text":"Stuur Invoice naar Inkoop", "key":-23, "loc":"43 557.25"},
{"text":"Ontvangst", "key":-24, "loc":"626 650.25"},
{"text":"Tekend vr \nontvangst", "key":-25, "loc":"445 650.25"},
{"text":"Prestatie op invoice door de manager\n(binnen & buitenland)", "key":-26, "loc":"256 650.25"},
{"text":"Oro tekenen en mailen voor Inkoop (buitenland)", "key":-27, "loc":"34 650.25"},
{"text":"Verwerkt in exact", "key":-28, "loc":"256 763.25"},
{"text":"Levering\naanvrager", "key":-29, "loc":"28 763.25"},
{"text":"Uitbedaling samen met bestelbon (leverancier) en gepresenteerde invoice door de manager", "key":-30, "loc":"553 838.25"},
{"text":"Uitbetaling", "key":-31, "loc":"181 849.25"},
{"text":"Ontvangst BO met onderliggende stukken", "key":-32, "loc":"-41 849.25"},
{"category":"End", "text":"End", "key":-4, "loc":"342 838.25"},
{"category":"End", "text":"End", "key":-33, "loc":"-86 763.25"}
 ],
  "linkDataArray": [
{"from":1, "to":2, "fromPort":"R", "toPort":"L", "points":[116.49999999999994,19.000000000000018,126.49999999999994,19.000000000000018,154.00000000000003,19.000000000000018,154.00000000000003,19,181.5000000000001,19,191.5000000000001,19]},
{"from":2, "to":3, "fromPort":"B", "toPort":"T", "points":[270.0000000000001,43.1,270.0000000000001,53.1,270.0000000000001,71.40000000000003,45.99999999999994,71.40000000000003,45.99999999999994,89.70000000000006,45.99999999999994,99.70000000000006]},
{"from":6, "to":7, "fromPort":"R", "toPort":"L", "points":[328.4999999999999,275.0000000000002,338.4999999999999,275.0000000000002,367.2499999999999,275.0000000000002,367.2499999999999,275.0000000000002,395.9999999999999,275.0000000000002,405.9999999999999,275.0000000000002]},
{"from":7, "to":8, "fromPort":"R", "toPort":"L", "points":[539.9999999999999,275.0000000000002,549.9999999999999,275.0000000000002,569,275.0000000000002,569,274.999999999999,588.0000000000001,274.999999999999,598.0000000000001,274.999999999999]},
{"from":-1, "to":1, "fromPort":"R", "toPort":"L", "points":[-98.79069767441861,19,-88.79069767441861,19,-57.64534883720933,19,-57.64534883720933,19.000000000000018,-26.500000000000057,19.000000000000018,-16.500000000000057,19.000000000000018]},
{"from":3, "to":-3, "fromPort":"R", "toPort":"L", "points":[103.99999999999994,116.00000000000006,113.99999999999994,116.00000000000006,136.24999999999997,116.00000000000006,136.24999999999997,116.25,158.5,116.25,168.5,116.25]},
{"from":-3, "to":6, "fromPort":"B", "toPort":"T", "visible":true, "points":[288,148.35000000000002,288,158.35000000000002,288,203.52500000000012,279.9999999999999,203.52500000000012,279.9999999999999,248.70000000000022,279.9999999999999,258.7000000000002]},
{"from":-3, "to":-11, "fromPort":"R", "toPort":"L", "visible":true, "points":[407.5,116.25,417.5,116.25,439.5,116.25,439.5,116.25,461.5,116.25,471.5,116.25]},
{"from":-11, "to":-12, "fromPort":"R", "toPort":"L", "points":[564.5,116.25,574.5,116.25,584.25,116.25,584.25,116.25,594,116.25,604,116.25]},
{"from":-12, "to":-14, "fromPort":"R", "toPort":"L", "points":[738,116.25,748,116.25,758.75,116.25,758.75,116.25,769.5,116.25,779.5,116.25]},
{"from":8, "to":-15, "fromPort":"R", "toPort":"L", "points":[750.0000000000001,274.999999999999,760.0000000000001,274.999999999999,772,274.999999999999,772,275.25,784,275.25,794,275.25]},
{"from":-14, "to":-15, "fromPort":"B", "toPort":"T", "points":[859,140.35000000000002,859,150.35000000000002,859,195.75,859,195.75,859,241.15,859,251.15]},
{"from":-15, "to":-16, "fromPort":"B", "toPort":"T", "points":[859,299.35,859,309.35,859,327.75,859,327.75,859,346.15,859,356.15]},
{"from":-16, "to":-17, "fromPort":"L", "toPort":"R", "points":[805.5,380.25,795.5,380.25,771.5,380.25,771.5,380.25,747.5,380.25,737.5,380.25]},
{"from":-16, "to":-18, "fromPort":"B", "toPort":"T", "points":[859,404.34999999999997,859,414.34999999999997,859,443.35,859,443.35,859,472.35,859,482.35]},
{"from":-17, "to":-19, "fromPort":"L", "toPort":"R", "points":[572.5,380.25,562.5,380.25,550.5,380.25,550.5,376.25,538.5,376.25,528.5,376.25]},
{"from":-19, "to":-21, "fromPort":"L", "toPort":"R", "visible":true, "points":[313.5,376.25,303.5,376.25,270,376.25,270,447.25,236.5,447.25,226.5,447.25]},
{"from":-19, "to":-22, "fromPort":"L", "toPort":"T", "visible":true, "points":[313.5,376.25,303.5,376.25,-177,376.25,-177,395.2,-177,414.15,-177,424.15]},
{"from":-21, "to":-23, "fromPort":"B", "toPort":"T", "points":[143,471.34999999999997,143,481.34999999999997,143,502.25,43,502.25,43,523.15,43,533.15]},
{"from":-23, "to":-22, "fromPort":"L", "toPort":"R", "points":[-29.5,557.25,-39.5,557.25,-69,557.25,-69,448.25,-98.5,448.25,-108.5,448.25]},
{"from":-19, "to":-20, "fromPort":"B", "toPort":"T", "visible":true, "points":[421,423.95000000000005,421,433.95000000000005,421,470.05,417,470.05,417,506.15,417,516.15]},
{"from":-23, "to":-20, "fromPort":"R", "toPort":"L", "points":[115.5,557.25,125.5,557.25,226.75,557.25,226.75,540.25,328,540.25,338,540.25]},
{"from":-18, "to":-24, "fromPort":"B", "toPort":"R", "points":[859,546.15,859,556.15,859,650.25,769.75,650.25,680.5,650.25,670.5,650.25]},
{"from":-20, "to":-24, "fromPort":"R", "toPort":"T", "points":[496,540.25,506,540.25,626,540.25,626,582.1,626,623.95,626,633.95]},
{"from":-24, "to":-25, "fromPort":"L", "toPort":"R", "points":[581.5,650.25,571.5,650.25,535,650.25,535,650.25,498.5,650.25,488.5,650.25]},
{"from":-25, "to":-26, "fromPort":"L", "toPort":"R", "points":[401.5,650.25,391.5,650.25,370.75,650.25,370.75,650.25,350,650.25,340,650.25]},
{"from":-26, "to":-27, "fromPort":"L", "toPort":"R", "points":[172,650.25,162,650.25,146.25,650.25,146.25,650.25,130.5,650.25,120.5,650.25]},
{"from":-26, "to":-28, "fromPort":"B", "toPort":"T", "points":[256,682.15,256,692.15,256,714.55,256,714.55,256,736.95,256,746.95]},
{"from":-28, "to":-29, "fromPort":"L", "toPort":"R", "points":[187.9044418334961,763.25,177.9044418334961,763.25,129.70222091674805,763.25,129.70222091674805,763.25,81.5,763.25,71.5,763.25]},
{"from":-22, "to":-32, "fromPort":"B", "toPort":"L", "points":[-177,472.34999999999997,-177,482.34999999999997,-177,849.25,-158.25,849.25,-139.5,849.25,-129.5,849.25]},
{"from":-32, "to":-31, "fromPort":"R", "toPort":"L", "points":[47.5,849.25,57.5,849.25,91,849.25,91,849.25,124.5,849.25,134.5,849.25]},
{"from":-31, "to":-4, "fromPort":"R", "toPort":"L", "points":[227.5,849.25,237.5,849.25,274.3255813953489,849.25,274.3255813953489,838.25,311.1511627906977,838.25,321.1511627906977,838.25]},
{"from":-30, "to":-4, "fromPort":"L", "toPort":"R", "points":[464.5,838.25,454.5,838.25,413.6744186046512,838.25,413.6744186046512,838.25,372.84883720930236,838.25,362.84883720930236,838.25]},
{"from":-28, "to":-30, "fromPort":"R", "toPort":"T", "points":[324.0955581665039,763.25,334.0955581665039,763.25,553,763.25,553,768.1,553,772.95,553,782.95]},
{"from":-29, "to":-33, "fromPort":"L", "toPort":"R", "points":[-15.5,763.25,-25.5,763.25,-40.325581395348834,763.25,-40.325581395348834,763.25,-55.15116279069767,763.25,-65.15116279069767,763.25]}
 ]}
  </textarea>

                </div>
                </body>


            </div>
        </div>
    </section><!-- /.content -->
    </aside><!-- /.right-side -->
    </div>
    <!-- ./wrapper -->


    <script id="code">

        function init() {
            if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
            var $ = go.GraphObject.make;  // for conciseness in defining templates

            myDiagram =
                $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
                    {
                        initialContentAlignment: go.Spot.Center,

                        allowDrop: true,  // must be true to accept drops from the Palette
                        "LinkDrawn": showLinkLabel,  // this DiagramEvent listener is defined below
                        "LinkRelinked": showLinkLabel,
                        "animationManager.duration": 800, // slightly longer than default (600ms) animation
                        "undoManager.isEnabled": true  // enable undo & redo
                    });

            // when the document is modified, add a "*" to the title and enable the "Save" button
            myDiagram.addDiagramListener("Modified", function (e) {
                var button = document.getElementById("SaveButton");
                if (button) button.disabled = !myDiagram.isModified;
                var idx = document.title.indexOf("*");
                if (myDiagram.isModified) {
                    if (idx < 0) document.title += "*";
                } else {
                    if (idx >= 0) document.title = document.title.substr(0, idx);
                }
            });

            // helper definitions for node templates

            function nodeStyle() {
                return [
                    // The Node.location comes from the "loc" property of the node data,
                    // converted by the Point.parse static method.
                    // If the Node.location is changed, it updates the "loc" property of the node data,
                    // converting back using the Point.stringify static method.
                    new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
                    {
                        // the Node.location is at the center of each node
                        locationSpot: go.Spot.Center,
                        //isShadowed: true,
                        //shadowColor: "#888",
                        // handle mouse enter/leave events to show/hide the ports
                        mouseEnter: function (e, obj) {
                            showPorts(obj.part, true);
                        },
                        mouseLeave: function (e, obj) {
                            showPorts(obj.part, false);
                        }
                    }
                ];
            }

            // Define a function for creating a "port" that is normally transparent.
            // The "name" is used as the GraphObject.portId, the "spot" is used to control how links connect
            // and where the port is positioned on the node, and the boolean "output" and "input" arguments
            // control whether the user can draw links from or to the port.
            function makePort(name, spot, output, input) {
                // the port is basically just a small circle that has a white stroke when it is made visible
                return $(go.Shape, "Circle",
                    {
                        fill: "transparent",
                        stroke: null,  // this is changed to "white" in the showPorts function
                        desiredSize: new go.Size(8, 8),
                        alignment: spot, alignmentFocus: spot,  // align the port on the main Shape
                        portId: name,  // declare this object to be a "port"
                        fromSpot: spot, toSpot: spot,  // declare where links may connect at this port
                        fromLinkable: output, toLinkable: input,  // declare whether the user may draw links to/from here
                        cursor: "pointer"  // show a different cursor to indicate potential link point
                    });
            }

            // define the Node templates for regular nodes

            var lightText = 'whitesmoke';

            myDiagram.nodeTemplateMap.add("",  // the default category
                $(go.Node, "Spot", nodeStyle(),
                    // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
                    $(go.Panel, "Auto",
                        $(go.Shape, "Rectangle",
                            {fill: "#00A9C9", stroke: null}, new go.Binding("fill", "color"),
                            new go.Binding("figure", "figure")),
                        $(go.TextBlock,
                            {
                                font: "bold 11pt Helvetica, Arial, sans-serif",
                                stroke: lightText,
                                margin: 8,
                                maxSize: new go.Size(160, NaN),
                                wrap: go.TextBlock.WrapFit,
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    ),
                    // four named ports, one on each side:
                    makePort("T", go.Spot.Top, false, true),
                    makePort("L", go.Spot.Left, true, true),
                    makePort("R", go.Spot.Right, true, true),
                    makePort("B", go.Spot.Bottom, true, false)
                ));

            myDiagram.nodeTemplateMap.add("Start",
                $(go.Node, "Spot", nodeStyle(),
                    $(go.Panel, "Auto",
                        $(go.Shape, "Circle",
                            {minSize: new go.Size(40, 40), fill: "#79C900", stroke: null}),
                        $(go.TextBlock, "Start",
                            {font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText},
                            new go.Binding("text"))
                    ),
                    // three named ports, one on each side except the top, all output only:
                    makePort("L", go.Spot.Left, true, false),
                    makePort("R", go.Spot.Right, true, false),
                    makePort("B", go.Spot.Bottom, true, false)
                ));

            myDiagram.nodeTemplateMap.add("End",
                $(go.Node, "Spot", nodeStyle(),
                    $(go.Panel, "Auto",
                        $(go.Shape, "Circle",
                            {minSize: new go.Size(40, 40), fill: "#DC3C00", stroke: null}),
                        $(go.TextBlock, "End",
                            {font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText},
                            new go.Binding("text"))
                    ),
                    // three named ports, one on each side except the bottom, all input only:
                    makePort("T", go.Spot.Top, false, true),
                    makePort("L", go.Spot.Left, false, true),
                    makePort("R", go.Spot.Right, false, true)
                ));

            myDiagram.nodeTemplateMap.add("Comment",
                $(go.Node, "Auto", nodeStyle(),
                    $(go.Shape, "File",
                        {fill: "#EFFAB4", stroke: null}),
                    $(go.TextBlock,
                        {
                            margin: 5,
                            maxSize: new go.Size(200, NaN),
                            wrap: go.TextBlock.WrapFit,
                            textAlign: "center",
                            editable: true,
                            font: "bold 12pt Helvetica, Arial, sans-serif",
                            stroke: '#454545'
                        },
                        new go.Binding("text").makeTwoWay())
                    // no ports, because no links are allowed to connect with a comment
                ));


            // replace the default Link template in the linkTemplateMap
            myDiagram.linkTemplate =
                $(go.Link,  // the whole link panel
                    {
                        routing: go.Link.AvoidsNodes,
                        curve: go.Link.JumpOver,
                        corner: 5, toShortLength: 4,
                        relinkableFrom: true,
                        relinkableTo: true,
                        reshapable: true,
                        resegmentable: true,
                        // mouse-overs subtly highlight links:
                        mouseEnter: function (e, link) {
                            link.findObject("HIGHLIGHT").stroke = "rgba(30,144,255,0.2)";
                        },
                        mouseLeave: function (e, link) {
                            link.findObject("HIGHLIGHT").stroke = "transparent";
                        }
                    },
                    new go.Binding("points").makeTwoWay(),
                    $(go.Shape,  // the highlight shape, normally transparent
                        {isPanelMain: true, strokeWidth: 8, stroke: "transparent", name: "HIGHLIGHT"}),
                    $(go.Shape,  // the link path shape
                        {isPanelMain: true, stroke: "gray", strokeWidth: 2}),
                    $(go.Shape,  // the arrowhead
                        {toArrow: "standard", stroke: null, fill: "gray"}),
                    $(go.Panel, "Auto",  // the link label, normally not visible
                        {visible: false, name: "LABEL", segmentIndex: 2, segmentFraction: 0.5},
                        new go.Binding("visible", "visible").makeTwoWay(),
                        $(go.Shape, "RoundedRectangle",  // the label shape
                            {fill: "#F8F8F8", stroke: null}),
                        $(go.TextBlock, "Yes",  // the label
                            {
                                textAlign: "center",
                                font: "10pt helvetica, arial, sans-serif",
                                stroke: "#333333",
                                editable: true
                            },
                            new go.Binding("text").makeTwoWay())
                    )
                );

            // Make link labels visible if coming out of a "conditional" node.
            // This listener is called by the "LinkDrawn" and "LinkRelinked" DiagramEvents.
            function showLinkLabel(e) {
                var label = e.subject.findObject("LABEL");
                if (label !== null) label.visible = (e.subject.fromNode.data.figure === "Diamond");
            }

            // temporary links used by LinkingTool and RelinkingTool are also orthogonal:
            myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Orthogonal;
            myDiagram.toolManager.relinkingTool.temporaryLink.routing = go.Link.Orthogonal;

            load();  // load an initial diagram from some JSON text

            // initialize the Palette that is on the left side of the page
            myPalette =
                $(go.Palette, "myPaletteDiv",  // must name or refer to the DIV HTML element
                    {
                        "animationManager.duration": 800, // slightly longer than default (600ms) animation
                        nodeTemplateMap: myDiagram.nodeTemplateMap,  // share the templates used by myDiagram
                        model: new go.GraphLinksModel([  // specify the contents of the Palette
                            {category: "Start", text: "Start"},
                            {text: "Step"},
                            {text: "???", figure: "Diamond"},
                            {category: "End", text: "End"},
                            {category: "Comment", text: "Comment"}
                        ])
                    });

        }

        // Make all ports on a node visible when the mouse is over the node
        function showPorts(node, show) {
            var diagram = node.diagram;
            if (!diagram || diagram.isReadOnly || !diagram.allowLink) return;
            node.ports.each(function (port) {
                port.stroke = (show ? "white" : null);
            });
        }

        function load() {
            myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
        }

        // add an SVG rendering of the diagram at the end of this page
        function makeSVG() {
            var svg = myDiagram.makeSvg({
                scale: 0.5
            });
            svg.style.border = "1px solid black";
            obj = document.getElementById("SVGArea");
            obj.appendChild(svg);
            if (obj.children.length > 0) {
                obj.replaceChild(svg, obj.children[0]);
            }
        }
    </script>

    <script>
        var can = document.getElementById('myDiagramDiv');
        var ctx = can.getContext('2d');


        var img = new Image();
        img.src = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAOsAAABQAQMAAADCyRAgAAAABlBMVEUAAADT09OfZycUAAAAAXRSTlMAQObYZgAAAjtJREFUSMft1DFv00AUB/DnYBFbLGe3IkFKLZ+pRAcELWOUSlfX1GajIyNMsKXCg1mqS3QotmQFe0BigYGRiY8QxNKRTiwMbjqxIaZucHdxSaU6jVSQkApv8ZN+ku/uf6cH8BerPgJ/xL8UjCrWbAhsyaiKkVEEdqcfZS/WrVsVXEMBuH2WZTleq2QfXE/NaI5xBX9HpNj1Otmgmk1EbLLiZfEMXgw4y7UrWHM4uyjN80qufzgcjDooHA5fWxj+1x8pVQEURdGljyNKN0CRL4rAETwurwToKmNMXcY9+vCYFRXikrv0vmSnT7et25+dG4OBr6jPfhidBwW/75ggzrBsU7qN15pvV4JgrwcsMdxH/FeIEpSmkeR7GKOXAS8oWPyu5pYchgy8E+xDi7O1+W3Cqvq8YJzvlkyoytlx4ZiZop7knmBXMt9aHLOa4E3OcSy2xtnbkmt3Cep2o/qhiMXCn+IBPxgcRUOvvVHIWM4KdQ7zzP/JQkS7DFAjSC9fkshi2jaJpnEGpMCvgNRpu+i/saL3bX/9yc6V/XFh3WxcjUL2lLe41eEcBBobbQV5kujmAsKrzVcsZYloxXswBVM3MHRdN02EbZTxl9mT7ZT9Cm7tAhgTJvlprpG5jPYE863pyTXJzYylacLb62JryB9qEW37S3r36/4YWXYDRWG4w9slcbDTMc5J+bf4QhU5LzfkIIOD8ZdKLgeZuXCnOmI5yJSa6cxm/2wmvfPyZJCZM1kMMu1g7Fysm/4JnKzTuTHtBGAAAAAASUVORK5CYII%3D";

        img.onload = function () {
            ctx.drawImage(img, 0, 0);
        }
    </script>
<?php require_once(TEMPLATE_PATH . 'footer.include.php'); ?>