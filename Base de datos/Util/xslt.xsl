<?xml version="1.0"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
 <html>
<head>
  <title>Libros</title>
  <style type="text/css">
   body {
   text-align : center;
   width: 600px;
   margin: 0 auto;
   color: ;
   margin-bottom: 100px;
   font-size: 25px

     }
   </style>
</head>
 <body>
   <h2>Libros</h2>
   <table border="1">
     <tr bgcolor="#9acd32">
       <th>Titulo</th>
       <th>Autor</th>
       <th>Precio</th>
     </tr>
      <xsl:for-each select="bookstore/book">
       <xsl:choose>
     <xsl:when test="precio>11">
       <tr style="text-align: center; width: 100%">
         <td bgcolor="red"><xsl:value-of select="title"/></td>
         <td bgcolor="blue"><xsl:value-of select="autor"/></td>
         <td><xsl:value-of select="precio"/></td>
       </tr>
      </xsl:when>
      <xsl:otherwise>
        <tr >
          <td ><xsl:value-of select="title"/></td>
          <td ><xsl:value-of select="autor"/></td>
          <td><xsl:value-of select="precio"/></td>
        </tr>
      </xsl:otherwise>
    </xsl:choose>


          </xsl:for-each>
   </table>
 </body>
 </html>
</xsl:template>
</xsl:stylesheet>
