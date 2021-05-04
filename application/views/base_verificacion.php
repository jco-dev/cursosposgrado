<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (empty($contenido)) $contenido = ''; ?>

<!DOCTYPE html>
<html dir="ltr" lang="es" xml:lang="es">

<head>
	<title>MOODLE UPEA | Verificación de Certificados</title>
	<link rel="shortcut icon" href="https://plataformavirtual.upea.bo/theme/image.php/boost/theme/1608126776/favicon" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="moodle, MOODLE UPEA" />
	<link rel="stylesheet" type="text/css" href="https://plataformavirtual.upea.bo/theme/yui_combo.php?rollup/3.17.2/yui-moodlesimple-min.css" />
	<script id="firstthemesheet" type="text/css"></script>
	<link rel="stylesheet" type="text/css" href="https://plataformavirtual.upea.bo/theme/styles.php/boost/1608126776_1/all" />
	<link href="<?= base_url('assets/css/style.bundle.css') ?>" rel="stylesheet" type="text/css" />
	<script>
		//<![CDATA[
		var M = {};
		M.yui = {};
		M.pageloadstarttime = new Date();
		M.cfg = {
			"wwwroot": "https:\/\/plataformavirtual.upea.bo",
			"sesskey": "YwBAtzMrwl",
			"sessiontimeout": "28800",
			"themerev": "1608126776",
			"slasharguments": 1,
			"theme": "boost",
			"iconsystemmodule": "core\/icon_system_fontawesome",
			"jsrev": "1608126776",
			"admin": "admin",
			"svgicons": true,
			"usertimezone": "Am\u00e9rica\/La_Paz",
			"contextid": 2,
			"langrev": 1614154510,
			"templaterev": "1608126776"
		};
		var yui1ConfigFn = function(me) {
			if (/-skin|reset|fonts|grids|base/.test(me.name)) {
				me.type = 'css';
				me.path = me.path.replace(/\.js/, '.css');
				me.path = me.path.replace(/\/yui2-skin/, '/assets/skins/sam/yui2-skin')
			}
		};
		var yui2ConfigFn = function(me) {
			var parts = me.name.replace(/^moodle-/, '').split('-'),
				component = parts.shift(),
				module = parts[0],
				min = '-min';
			if (/-(skin|core)$/.test(me.name)) {
				parts.pop();
				me.type = 'css';
				min = ''
			}
			if (module) {
				var filename = parts.join('-');
				me.path = component + '/' + module + '/' + filename + min + '.' + me.type
			} else {
				me.path = component + '/' + component + '.' + me.type
			}
		};
		YUI_config = {
			"debug": false,
			"base": "https:\/\/plataformavirtual.upea.bo\/lib\/yuilib\/3.17.2\/",
			"comboBase": "https:\/\/plataformavirtual.upea.bo\/theme\/yui_combo.php?",
			"combine": true,
			"filter": null,
			"insertBefore": "firstthemesheet",
			"groups": {
				"yui2": {
					"base": "https:\/\/plataformavirtual.upea.bo\/lib\/yuilib\/2in3\/2.9.0\/build\/",
					"comboBase": "https:\/\/plataformavirtual.upea.bo\/theme\/yui_combo.php?",
					"combine": true,
					"ext": false,
					"root": "2in3\/2.9.0\/build\/",
					"patterns": {
						"yui2-": {
							"group": "yui2",
							"configFn": yui1ConfigFn
						}
					}
				},
				"moodle": {
					"name": "moodle",
					"base": "https:\/\/plataformavirtual.upea.bo\/theme\/yui_combo.php?m\/1608126776\/",
					"combine": true,
					"comboBase": "https:\/\/plataformavirtual.upea.bo\/theme\/yui_combo.php?",
					"ext": false,
					"root": "m\/1608126776\/",
					"patterns": {
						"moodle-": {
							"group": "moodle",
							"configFn": yui2ConfigFn
						}
					},
					"filter": null,
					"modules": {
						"moodle-core-event": {
							"requires": ["event-custom"]
						},
						"moodle-core-actionmenu": {
							"requires": ["base", "event", "node-event-simulate"]
						},
						"moodle-core-blocks": {
							"requires": ["base", "node", "io", "dom", "dd", "dd-scroll", "moodle-core-dragdrop", "moodle-core-notification"]
						},
						"moodle-core-lockscroll": {
							"requires": ["plugin", "base-build"]
						},
						"moodle-core-languninstallconfirm": {
							"requires": ["base", "node", "moodle-core-notification-confirm", "moodle-core-notification-alert"]
						},
						"moodle-core-chooserdialogue": {
							"requires": ["base", "panel", "moodle-core-notification"]
						},
						"moodle-core-popuphelp": {
							"requires": ["moodle-core-tooltip"]
						},
						"moodle-core-tooltip": {
							"requires": ["base", "node", "io-base", "moodle-core-notification-dialogue", "json-parse", "widget-position", "widget-position-align", "event-outside", "cache-base"]
						},
						"moodle-core-formchangechecker": {
							"requires": ["base", "event-focus", "moodle-core-event"]
						},
						"moodle-core-notification": {
							"requires": ["moodle-core-notification-dialogue", "moodle-core-notification-alert", "moodle-core-notification-confirm", "moodle-core-notification-exception", "moodle-core-notification-ajaxexception"]
						},
						"moodle-core-notification-dialogue": {
							"requires": ["base", "node", "panel", "escape", "event-key", "dd-plugin", "moodle-core-widget-focusafterclose", "moodle-core-lockscroll"]
						},
						"moodle-core-notification-alert": {
							"requires": ["moodle-core-notification-dialogue"]
						},
						"moodle-core-notification-confirm": {
							"requires": ["moodle-core-notification-dialogue"]
						},
						"moodle-core-notification-exception": {
							"requires": ["moodle-core-notification-dialogue"]
						},
						"moodle-core-notification-ajaxexception": {
							"requires": ["moodle-core-notification-dialogue"]
						},
						"moodle-core-maintenancemodetimer": {
							"requires": ["base", "node"]
						},
						"moodle-core-dragdrop": {
							"requires": ["base", "node", "io", "dom", "dd", "event-key", "event-focus", "moodle-core-notification"]
						},
						"moodle-core-handlebars": {
							"condition": {
								"trigger": "handlebars",
								"when": "after"
							}
						},
						"moodle-core_availability-form": {
							"requires": ["base", "node", "event", "event-delegate", "panel", "moodle-core-notification-dialogue", "json"]
						},
						"moodle-backup-confirmcancel": {
							"requires": ["node", "node-event-simulate", "moodle-core-notification-confirm"]
						},
						"moodle-backup-backupselectall": {
							"requires": ["node", "event", "node-event-simulate", "anim"]
						},
						"moodle-course-categoryexpander": {
							"requires": ["node", "event-key"]
						},
						"moodle-course-util": {
							"requires": ["node"],
							"use": ["moodle-course-util-base"],
							"submodules": {
								"moodle-course-util-base": {},
								"moodle-course-util-section": {
									"requires": ["node", "moodle-course-util-base"]
								},
								"moodle-course-util-cm": {
									"requires": ["node", "moodle-course-util-base"]
								}
							}
						},
						"moodle-course-management": {
							"requires": ["base", "node", "io-base", "moodle-core-notification-exception", "json-parse", "dd-constrain", "dd-proxy", "dd-drop", "dd-delegate", "node-event-delegate"]
						},
						"moodle-course-formatchooser": {
							"requires": ["base", "node", "node-event-simulate"]
						},
						"moodle-course-dragdrop": {
							"requires": ["base", "node", "io", "dom", "dd", "dd-scroll", "moodle-core-dragdrop", "moodle-core-notification", "moodle-course-coursebase", "moodle-course-util"]
						},
						"moodle-form-dateselector": {
							"requires": ["base", "node", "overlay", "calendar"]
						},
						"moodle-form-shortforms": {
							"requires": ["node", "base", "selector-css3", "moodle-core-event"]
						},
						"moodle-form-passwordunmask": {
							"requires": []
						},
						"moodle-question-chooser": {
							"requires": ["moodle-core-chooserdialogue"]
						},
						"moodle-question-searchform": {
							"requires": ["base", "node"]
						},
						"moodle-question-preview": {
							"requires": ["base", "dom", "event-delegate", "event-key", "core_question_engine"]
						},
						"moodle-availability_completion-form": {
							"requires": ["base", "node", "event", "moodle-core_availability-form"]
						},
						"moodle-availability_date-form": {
							"requires": ["base", "node", "event", "io", "moodle-core_availability-form"]
						},
						"moodle-availability_grade-form": {
							"requires": ["base", "node", "event", "moodle-core_availability-form"]
						},
						"moodle-availability_group-form": {
							"requires": ["base", "node", "event", "moodle-core_availability-form"]
						},
						"moodle-availability_grouping-form": {
							"requires": ["base", "node", "event", "moodle-core_availability-form"]
						},
						"moodle-availability_profile-form": {
							"requires": ["base", "node", "event", "moodle-core_availability-form"]
						},
						"moodle-mod_assign-history": {
							"requires": ["node", "transition"]
						},
						"moodle-mod_quiz-questionchooser": {
							"requires": ["moodle-core-chooserdialogue", "moodle-mod_quiz-util", "querystring-parse"]
						},
						"moodle-mod_quiz-util": {
							"requires": ["node", "moodle-core-actionmenu"],
							"use": ["moodle-mod_quiz-util-base"],
							"submodules": {
								"moodle-mod_quiz-util-base": {},
								"moodle-mod_quiz-util-slot": {
									"requires": ["node", "moodle-mod_quiz-util-base"]
								},
								"moodle-mod_quiz-util-page": {
									"requires": ["node", "moodle-mod_quiz-util-base"]
								}
							}
						},
						"moodle-mod_quiz-modform": {
							"requires": ["base", "node", "event"]
						},
						"moodle-mod_quiz-dragdrop": {
							"requires": ["base", "node", "io", "dom", "dd", "dd-scroll", "moodle-core-dragdrop", "moodle-core-notification", "moodle-mod_quiz-quizbase", "moodle-mod_quiz-util-base", "moodle-mod_quiz-util-page", "moodle-mod_quiz-util-slot", "moodle-course-util"]
						},
						"moodle-mod_quiz-quizbase": {
							"requires": ["base", "node"]
						},
						"moodle-mod_quiz-toolboxes": {
							"requires": ["base", "node", "event", "event-key", "io", "moodle-mod_quiz-quizbase", "moodle-mod_quiz-util-slot", "moodle-core-notification-ajaxexception"]
						},
						"moodle-mod_quiz-autosave": {
							"requires": ["base", "node", "event", "event-valuechange", "node-event-delegate", "io-form"]
						},
						"moodle-message_airnotifier-toolboxes": {
							"requires": ["base", "node", "io"]
						},
						"moodle-filter_glossary-autolinker": {
							"requires": ["base", "node", "io-base", "json-parse", "event-delegate", "overlay", "moodle-core-event", "moodle-core-notification-alert", "moodle-core-notification-exception", "moodle-core-notification-ajaxexception"]
						},
						"moodle-filter_mathjaxloader-loader": {
							"requires": ["moodle-core-event"]
						},
						"moodle-editor_atto-rangy": {
							"requires": []
						},
						"moodle-editor_atto-editor": {
							"requires": ["node", "transition", "io", "overlay", "escape", "event", "event-simulate", "event-custom", "node-event-html5", "node-event-simulate", "yui-throttle", "moodle-core-notification-dialogue", "moodle-core-notification-confirm", "moodle-editor_atto-rangy", "handlebars", "timers", "querystring-stringify"]
						},
						"moodle-editor_atto-plugin": {
							"requires": ["node", "base", "escape", "event", "event-outside", "handlebars", "event-custom", "timers", "moodle-editor_atto-menu"]
						},
						"moodle-editor_atto-menu": {
							"requires": ["moodle-core-notification-dialogue", "node", "event", "event-custom"]
						},
						"moodle-report_eventlist-eventfilter": {
							"requires": ["base", "event", "node", "node-event-delegate", "datatable", "autocomplete", "autocomplete-filters"]
						},
						"moodle-report_loglive-fetchlogs": {
							"requires": ["base", "event", "node", "io", "node-event-delegate"]
						},
						"moodle-gradereport_grader-gradereporttable": {
							"requires": ["base", "node", "event", "handlebars", "overlay", "event-hover"]
						},
						"moodle-gradereport_history-userselector": {
							"requires": ["escape", "event-delegate", "event-key", "handlebars", "io-base", "json-parse", "moodle-core-notification-dialogue"]
						},
						"moodle-tool_capability-search": {
							"requires": ["base", "node"]
						},
						"moodle-tool_lp-dragdrop-reorder": {
							"requires": ["moodle-core-dragdrop"]
						},
						"moodle-tool_monitor-dropdown": {
							"requires": ["base", "event", "node"]
						},
						"moodle-assignfeedback_editpdf-editor": {
							"requires": ["base", "event", "node", "io", "graphics", "json", "event-move", "event-resize", "transition", "querystring-stringify-simple", "moodle-core-notification-dialog", "moodle-core-notification-alert", "moodle-core-notification-warning", "moodle-core-notification-exception", "moodle-core-notification-ajaxexception"]
						},
						"moodle-atto_accessibilitychecker-button": {
							"requires": ["color-base", "moodle-editor_atto-plugin"]
						},
						"moodle-atto_accessibilityhelper-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_align-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_bold-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_charmap-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_clear-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_collapse-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_emojipicker-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_emoticon-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_equation-button": {
							"requires": ["moodle-editor_atto-plugin", "moodle-core-event", "io", "event-valuechange", "tabview", "array-extras"]
						},
						"moodle-atto_h5p-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_html-beautify": {},
						"moodle-atto_html-codemirror": {
							"requires": ["moodle-atto_html-codemirror-skin"]
						},
						"moodle-atto_html-button": {
							"requires": ["promise", "moodle-editor_atto-plugin", "moodle-atto_html-beautify", "moodle-atto_html-codemirror", "event-valuechange"]
						},
						"moodle-atto_image-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_indent-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_italic-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_link-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_managefiles-usedfiles": {
							"requires": ["node", "escape"]
						},
						"moodle-atto_managefiles-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_media-button": {
							"requires": ["moodle-editor_atto-plugin", "moodle-form-shortforms"]
						},
						"moodle-atto_noautolink-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_orderedlist-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_recordrtc-button": {
							"requires": ["moodle-editor_atto-plugin", "moodle-atto_recordrtc-recording"]
						},
						"moodle-atto_recordrtc-recording": {
							"requires": ["moodle-atto_recordrtc-button"]
						},
						"moodle-atto_rtl-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_strike-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_subscript-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_superscript-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_table-button": {
							"requires": ["moodle-editor_atto-plugin", "moodle-editor_atto-menu", "event", "event-valuechange"]
						},
						"moodle-atto_title-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_underline-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_undo-button": {
							"requires": ["moodle-editor_atto-plugin"]
						},
						"moodle-atto_unorderedlist-button": {
							"requires": ["moodle-editor_atto-plugin"]
						}
					}
				},
				"gallery": {
					"name": "gallery",
					"base": "https:\/\/plataformavirtual.upea.bo\/lib\/yuilib\/gallery\/",
					"combine": true,
					"comboBase": "https:\/\/plataformavirtual.upea.bo\/theme\/yui_combo.php?",
					"ext": false,
					"root": "gallery\/1608126776\/",
					"patterns": {
						"gallery-": {
							"group": "gallery"
						}
					}
				}
			},
			"modules": {
				"core_filepicker": {
					"name": "core_filepicker",
					"fullpath": "https:\/\/plataformavirtual.upea.bo\/lib\/javascript.php\/1608126776\/repository\/filepicker.js",
					"requires": ["base", "node", "node-event-simulate", "json", "async-queue", "io-base", "io-upload-iframe", "io-form", "yui2-treeview", "panel", "cookie", "datatable", "datatable-sort", "resize-plugin", "dd-plugin", "escape", "moodle-core_filepicker", "moodle-core-notification-dialogue"]
				},
				"core_comment": {
					"name": "core_comment",
					"fullpath": "https:\/\/plataformavirtual.upea.bo\/lib\/javascript.php\/1608126776\/comment\/comment.js",
					"requires": ["base", "io-base", "node", "json", "yui2-animation", "overlay", "escape"]
				},
				"mathjax": {
					"name": "mathjax",
					"fullpath": "https:\/\/cdn.jsdelivr.net\/npm\/mathjax@2.7.8\/MathJax.js?delayStartupUntil=configured"
				}
			}
		};
		M.yui.loader = {
			modules: {}
		};
		//]]>
	</script>
	<meta name="robots" content="noindex" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style>
		#message {
			position: fixed;
			top: 10;
			left: 25%;
			width: 50%;
			text-align: center;
			z-index: 2000;
		}
	</style>
</head>

<body class="">
	<div id="message">
		<?php foreach ($this->session->flashdata() as $kmsg => $msg) : ?>
			<div class="alert alert-<?php echo $kmsg; ?> alert-dismissible">
				<strong>
					<i class="fa fa-<?php echo $kmsg; ?>"></i>
					<?php echo mb_convert_case($kmsg, MB_CASE_UPPER) . ':'; ?>
				</strong>
				<div class="alert-text"><?php echo $msg; ?></div>
				<div class="alert-close">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true"><i class="ki ki-close"></i></span>
					</button>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
	<?php echo $contenido; ?>
</body>

</html>