define("ace/ext/rtl",["require","exports","module","ace/editor","ace/config"],(function(e,t,i){"use strict";function n(e,t){var i=t.getSelection().lead;t.session.$bidiHandler.isRtlLine(i.row)&&0===i.column&&(t.session.$bidiHandler.isMoveLeftOperation&&i.row>0?t.getSelection().moveCursorTo(i.row-1,t.session.getLine(i.row-1).length):t.getSelection().isEmpty()?i.column+=1:i.setPosition(i.row,i.column+1))}function r(e){e.editor.session.$bidiHandler.isMoveLeftOperation=/gotoleft|selectleft|backspace|removewordleft/.test(e.command.name)}function o(e,t){var i=t.session;if(i.$bidiHandler.currentRow=null,i.$bidiHandler.isRtlLine(e.start.row)&&"insert"===e.action&&e.lines.length>1)for(var n=e.start.row;n<e.end.row;n++)i.getLine(n+1).charAt(0)!==i.$bidiHandler.RLE&&(i.doc.$lines[n+1]=i.$bidiHandler.RLE+i.getLine(n+1))}function s(e,t){var i=t.session.$bidiHandler,n=t.$textLayer.$lines.cells,r=t.layerConfig.width-t.layerConfig.padding+"px";n.forEach((function(e){var t=e.element.style;i&&i.isRtlLine(e.row)?(t.direction="rtl",t.textAlign="right",t.width=r):(t.direction="",t.textAlign="",t.width="")}))}function d(e){function t(e){var t=e.element.style;t.direction=t.textAlign=t.width=""}var i=e.$textLayer.$lines;i.cells.forEach(t),i.cellCache.forEach(t)}var l=[{name:"leftToRight",bindKey:{win:"Ctrl-Alt-Shift-L",mac:"Command-Alt-Shift-L"},exec:function(e){e.session.$bidiHandler.setRtlDirection(e,!1)},readOnly:!0},{name:"rightToLeft",bindKey:{win:"Ctrl-Alt-Shift-R",mac:"Command-Alt-Shift-R"},exec:function(e){e.session.$bidiHandler.setRtlDirection(e,!0)},readOnly:!0}],a=e("../editor").Editor;e("../config").defineOptions(a.prototype,"editor",{rtlText:{set:function(e){e?(this.on("change",o),this.on("changeSelection",n),this.renderer.on("afterRender",s),this.commands.on("exec",r),this.commands.addCommands(l)):(this.off("change",o),this.off("changeSelection",n),this.renderer.off("afterRender",s),this.commands.off("exec",r),this.commands.removeCommands(l),d(this.renderer)),this.renderer.updateFull()}},rtl:{set:function(e){this.session.$bidiHandler.$isRtl=e,e?(this.setOption("rtlText",!1),this.renderer.on("afterRender",s),this.session.$bidiHandler.seenBidi=!0):(this.renderer.off("afterRender",s),d(this.renderer)),this.renderer.updateFull()}}})})),window.require(["ace/ext/rtl"],(function(e){"object"==typeof module&&"object"==typeof exports&&module&&(module.exports=e)}));
