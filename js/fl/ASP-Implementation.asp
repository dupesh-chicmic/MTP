<HTML>
<HEAD>
<TITLE>Image zoom for product showcase improve, web image zoom tool</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
<META NAME="Description" CONTENT="Image zoom displays products in your online store with zoom feature without changing store layout">
<META NAME="Keywords" CONTENT="image zoom, web image zoom, design, flash">
<META NAME="robots" CONTENT="index, follow"> 
<META content="INDEX, FOLLOW" name=GOOGLEBOT>

</HEAD>
<body>

<h1>Image zoom software implementation</h1>

<h2>Implementation syntax, parameters are passed as:

</h2>

<p><b>imagezoom.swf?image=image1.jpg&amp;imagebig=imagebig1.jpg&amp;imgW=320&amp;imgH=240</b>

</p>
<h3>Where:

</h3>

<p><b>image</b> is the url of the small image<br>
<b>imagebig</b> is the url of the image to the bigger image when zooming<br>
<b>imgW</b> is the image width in pixels<br>
<b>imgH</b> is the image height in pixels

</p>

<br><br><h3>ImageZoom Function call</h3>
call</font></b> ImageZoom (&quot;snake.jpg&quot;,
&quot;snakebig.jpg&quot;, &quot;320&quot;, &quot;180&quot;)
<br><br><h3>ImageZoom Function Definition</h3>
function ImageZoom(zimage, zimageBig, zimgW, zimgH)

<h1>Implementation samples of image zoom software</h1>

<br><br><br>

<%function ImageZoom(zimage, zimageBig, zimgW, zimgH)%>
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="<%=zimgW%>" HEIGHT="<%=zimgH%>" id="imagezoom" ALIGN="middle">
<param name="movie" value="imagezoom.swf?image=<%=zimage%>&imagebig=<%=zimageBig%>&imgW=<%=zimgW%>&imgH=<%=zimgH%>"/>
<param name="loop" value="false" />
<param name="menu" value="false" />
<param name="quality" value="high" />
<param name="bgcolor" value="#ffffff" />
<EMBED WIDTH="<%=zimgW%>" HEIGHT="<%=zimgH%>" src="imagezoom.swf?image=<%=zimage%>&imagebig=<%=zimageBig%>&imgW=<%=zimgW%>&imgH=<%=zimgH%>" loop="false" menu="false" quality="high" bgcolor="#ffffff"  NAME="imagezoom" ALIGN="middle" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
</OBJECT>
<%end function%>

<center>
<%call ImageZoom ("snake.jpg", "snakebig.jpg", "320", "180")%>
<br><br><br>
<%call ImageZoom ("jackson.jpg", "jacksonbig.jpg", "320", "240")%>
<br><br><br>
<%call ImageZoom ("sweater.jpg", "sweaterbig.jpg", "220", "387")%>
</center>
<br><br><br>


<br><h1>Image zoom Software License</h1>
<h2>Copyright (c) 2005 Sysworkers LC. All rights reserved.<br>
Coded by Gustavo de Tanti</h2>
<h3>Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:</h3>
<p><b>1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.<br>
<br>
2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation
and/or other materials provided with the distribution.<br>
<br>
3. The end-user documentation included with the redistribution, if any, must include the following acknowledgment:<br>
"This product includes Free Image zoom developed by Sysworkers LC.<br>
Distributed By http://www.digitalbrochuredesign.com"<br>
<br>
4. This is not a mandatory condition, but we ask you to place a link in your website where you are using image zoom
software.&nbsp;<br>
Use the following code to paste on your website<br>
Powered by: &lt;a title="Free image zoom" href="http://www.digitalbrochuredesign.com/image-zoom/">Image zoom&lt;/a></b><br>
</p>


This software consists of voluntary contributions made by many individuals on behalf of Sysworkers LC.<br>
Distributed by <a href="http://www.DigitalBrochureDesign.com"> www.DigitalBrochureDesign.com</a>
under license of Sysworkers LC Miami, FL. USA.


<br>



</body>
</html>

