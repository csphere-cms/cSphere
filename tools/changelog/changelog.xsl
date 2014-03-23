<?xml version="1.0" encoding="utf-8" ?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
  <xsl:output method="xml" encoding="utf-8" omit-xml-declaration="yes" indent="yes" />
  <xsl:template match="/">
      <xsl:text disable-output-escaping="yes">&lt;</xsl:text>!DOCTYPE html<xsl:text disable-output-escaping="yes">&gt;</xsl:text>
      <html>
      <head>
        <title>Changelog</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" type="text/css" href="changelog.css" />
      </head>
      <body>
        <div id="content"><xsl:apply-templates /></div>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="changelog">
    <xsl:apply-templates />
  </xsl:template>
  <xsl:template match="updates">
    <nav>
      <div id="right_column">
        Jump to Version ..<br /><br />
        <xsl:for-each select="update">
          - <a href="#version{@version}"><xsl:value-of select="@version" /></a><br />
        </xsl:for-each>
        <br />
      </div>
    </nav>
    <section>
      <div id="left_column">
        <xsl:apply-templates />
      </div>
    </section>
  </xsl:template>
  <xsl:template match="history">
    <header>
      <span class="headline">History of <xsl:value-of select="@type" />: <xsl:value-of select="@name" /></span>
      <br />
    </header>
  </xsl:template>
  <xsl:template match="update">
    <br /><hr /><br />
    <span class="headline" id="version{@version}">Version <a href="#version{@version}"><xsl:value-of select="@version" /></a></span>
    <br />
    Release Date:
    <xsl:value-of select="substring(@published,1,4)" />-<xsl:value-of select="substring(@published,6,2)" />-<xsl:value-of select="substring(@published,9,2)" />
    // Compatible Until:
    <xsl:value-of select="substring(@compatible,1,4)" />-<xsl:value-of select="substring(@compatible,6,2)" />-<xsl:value-of select="substring(@compatible,9,2)" />
    <br />
    <xsl:apply-templates />
  </xsl:template>
  <xsl:template match="information">
    <br />
    <span class="headline">Information</span>
    <br />
    <span><xsl:apply-templates /></span>
    <br />
  </xsl:template>
  <xsl:template match="instructions">
    <br />
    <span class="headline">Instructions</span>
    <br />
    <span><xsl:apply-templates /></span>
    <br />
  </xsl:template>
  <xsl:template match="added">
    <br />
    <span class="headline">Added</span>
    <ul>
      <xsl:for-each select="item">
        <li><xsl:apply-templates /> (<xsl:value-of select="@author" />)<xsl:if test="@source != ''"> [<xsl:value-of select="@source" />]</xsl:if></li>
      </xsl:for-each>
    </ul>
  </xsl:template>
  <xsl:template match="reworked">
    <br />
    <span class="headline">Reworked</span>
    <ul>
      <xsl:for-each select="item">
        <li><xsl:apply-templates /> (<xsl:value-of select="@author" />)<xsl:if test="@source != ''"> [<xsl:value-of select="@source" />]</xsl:if></li>
      </xsl:for-each>
    </ul>
  </xsl:template>
  <xsl:template match="fixed">
    <br />
    <span class="headline">Fixed</span>
    <ul>
      <xsl:for-each select="item">
        <li><xsl:apply-templates /> (<xsl:value-of select="@author" />)<xsl:if test="@source != ''"> [<xsl:value-of select="@source" />]</xsl:if></li>
      </xsl:for-each>
    </ul>
  </xsl:template>
  <xsl:template match="removed">
    <br />
    <span class="headline">Removed</span>
    <ul>
      <xsl:for-each select="item">
        <li><xsl:apply-templates /> (<xsl:value-of select="@author" />)<xsl:if test="@source != ''"> [<xsl:value-of select="@source" />]</xsl:if></li>
      </xsl:for-each>
    </ul>
  </xsl:template>
  <xsl:template match="item" />
</xsl:stylesheet>
