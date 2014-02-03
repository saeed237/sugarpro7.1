/* The MIT License
     
     Copyright (c) 2011 goker.cebeci, http://gokercebeci.com
     
     Permission is hereby granted, free of charge, to any person obtaining a copy
     of this software and associated documentation files (the "Software"), to deal
     in the Software without restriction, including without limitation the rights
     to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
     copies of the Software, and to permit persons to whom the Software is
     furnished to do so, subject to the following conditions:
     
     The above copyright notice and this permission notice shall be included in
     all copies or substantial portions of the Software.
     
     THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
     IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
     FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
     AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
     LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
     OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
     THE SOFTWARE.
     
     */
(function($){var s;var m={init:function(){},start:function(){},complete:function(){},error:function(){return 0;},traverse:function(files,input,area){if(typeof files!=="undefined"){for(var i=0,l=files.length;i<l;i++){m.control(files[i],input,area);}}else{area.html(nosupport);}},control:function(file,input,area){var tld=file.name.toLowerCase().split(/\./);tld=tld[tld.length-1];if(input.data('type')&&!types.indexOf(file.type)){s.error({'error':'only image files: '+input.data('type')},input,area);return false;}
if(file.size>(s.maxsize*1048576)){s.error({'error':'max upload size: '+s.maxsize+'Mb'},input,area);return false;}
if((/image/i).test(file.type)&&input.data('canvas'))
m.resize(file,input,area);else
m.upload(file,input,area);},resize:function(file,input,area){var name=file.name;var canvas=document.createElement("canvas");var img=document.createElement("img");var WIDTH=0|input.data('width');var HEIGHT=0|input.data('height');var reader=new FileReader();reader.onloadend=function(e){img.src=e.target.result;var width=img.width;var height=img.height;var crop=input.data('crop');if((WIDTH&&width>WIDTH)||(HEIGHT&&height>HEIGHT)){ratio=width / height;if((ratio>=1||HEIGHT==0)&&WIDTH&&!crop){width=WIDTH;height=WIDTH / ratio;}else if(crop&&ratio<=(WIDTH / HEIGHT)){width=WIDTH;height=WIDTH / ratio;}else{width=HEIGHT*ratio;height=HEIGHT;}}
canvas.width=width;canvas.height=height;var ctx=canvas.getContext("2d");ctx.drawImage(img,0,0,width,height);var data=canvas.toDataURL("image/jpeg");if(data.length<=6){s.error({'error':'Image did not created. Please, try again.'},input,area);return 0;}else{file=m.dataURItoBlob(data);file.name=name;if(input.data('post')){m.upload(file,input,area);}else{$(canvas).appendTo(area);input.attr('disabled','disabled');$('<input>').attr('name',input.attr('name')).val(data).insertAfter(input);}}}
reader.readAsDataURL(file);},upload:function(file,input,area){area.find('div').empty();var progress=$('<div>',{'class':'progress'});area.append(progress);var xhr=new XMLHttpRequest();xhr.open("post",input.data('post'),true);xhr.setRequestHeader("X-Requested-With","XMLHttpRequest");xhr.upload.addEventListener("progress",function(e){if(e.lengthComputable){var loaded=Math.ceil((e.loaded / e.total)*100);progress.css({'height':loaded+"%",'line-height':(area.height()*loaded / 100)+'px'}).html(loaded+"%");}},false);xhr.addEventListener("load",function(e){var result=jQuery.parseJSON(e.target.responseText);s.complete(result,file,input,area);progress.addClass('uploaded');progress.html(s.uploaded).fadeOut('slow');},false);var fd=new FormData();for(var i in input.data())
if(typeof input.data(i)!=="object")
fd.append(i,input.data(i));fd.append(input.attr('name'),file);xhr.send(fd);},dataURItoBlob:function(dataURI){var byteString=atob(dataURI.split(',')[1]);var mimeString=dataURI.split(',')[0].split(':')[1].split(';')[0]
var ab=new ArrayBuffer(byteString.length);var ia=new Uint8Array(ab);for(var i=0;i<byteString.length;i++){ia[i]=byteString.charCodeAt(i);}
var bb=new(window.BlobBuilder||window.WebKitBlobBuilder||window.MozBlobBuilder)();bb.append(ab);return bb.getBlob(mimeString);}};$.fn.droparea=function(o){s={'init':m.init,'start':m.start,'complete':m.complete,'instructions':'drop a file to here','over':'drop file here!','nosupport':'No support for the File API in this web browser','noimage':'Unsupported file type!','uploaded':'Uploaded','maxsize':'10'};if(o)$.extend(s,o);this.each(function(){var area=$('<div class="'+$(this).attr('class')+'">').insertAfter($(this));var instructions=$('<div>').appendTo(area);var input=$(this).appendTo(area);s.init($(this));if(input.data('value')&&input.data('value').length)
$('<img src="'+input.data('value')+'">').appendTo(area);else
instructions.addClass('instructions').html(s.instructions);$(document).bind({dragleave:function(e){e.preventDefault();if(input.data('value')||area.find('img').length)
instructions.removeClass().empty();else
instructions.removeClass('over').html(s.instructions);},drop:function(e){e.preventDefault();if(input.data('value')||area.find('img').length)
instructions.removeClass().empty();else
instructions.removeClass('over').html(s.instructions);},dragenter:function(e){e.preventDefault();instructions.addClass('instructions over').html(s.over);},dragover:function(e){e.preventDefault();instructions.addClass('instructions over').html(s.over);}});this.addEventListener("drop",function(e){e.preventDefault();s.start($(this));m.traverse(e.dataTransfer.files,input,area);instructions.removeClass().empty();},false);input.change(function(e){m.traverse(e.target.files,input,area);});});};})(jQuery);