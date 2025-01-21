<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/livraria">
        <html>
            <body>
                <h1>Lista de Livros</h1>
                <table border="1">
                    <tr>
                        <th>Título</th>
                        <th>Autor</th>
                        <th>Preço</th>
                    </tr>
                    <!-- Percorrer todos os livros -->
                    <xsl:for-each select="livro">
                        <tr>
                            <td><xsl:value-of select="titulo"/></td>
                            <td><xsl:value-of select="autor"/></td>
                            <td><xsl:value-of select="preco"/></td>
                        </tr>
                    </xsl:for-each>
                </table>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
