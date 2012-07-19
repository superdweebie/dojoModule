var profile = {
	"basePath":"..\/",
	"releaseDir":"public\/js\/dojo_rel",
	"action":"release",
	"cssOptimize":"comments",
	"layerOptimize":"closure",
	"stripConsole":"all",
	"selectorEngine":"acme",
	"packages":[
		{
			"name":"dojo",
			"location":"vendor\/dojo\/dojo"
		},
		{
			"name":"dijit",
			"location":"vendor\/dojo\/dijit"
		},
		{
			"name":"dojox",
			"location":"vendor\/dojo\/dojox"
		}
	],
	"layers":{
		"dojo\/dojo":{
			"include":[
				"dojo\/parser"
			],
			"custombase":true,
			"boot":true
		}
	}
}

if (typeof Packages !== 'undefined' && Packages.com.google.javascript.jscomp.Compiler) {
    Packages.com.google.javascript.jscomp.Compiler.setLoggingLevel(Packages.java.util.logging.Level.WARNING);
}
