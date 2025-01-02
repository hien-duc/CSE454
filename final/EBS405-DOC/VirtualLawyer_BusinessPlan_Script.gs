// Create a custom menu when the document is opened
function onOpen() {
  DocumentApp.getUi()
    .createMenu('Business Plan Format')
    .addItem('Format Document', 'formatBusinessPlan')
    .addItem('Clear Formatting', 'clearFormatting')
    .addItem('Create Table of Contents', 'createTableOfContents')
    .addToUi();
}

// Clear all existing formatting
function clearFormatting() {
  var doc = DocumentApp.getActiveDocument();
  var body = doc.getBody();
  
  // Reset margins to default
  body.setMarginBottom(72);
  body.setMarginTop(72);
  body.setMarginLeft(72);
  body.setMarginRight(72);

  // Clear header and footer if exists
  try {
    var header = doc.getHeader();
    if (header) {
      doc.removeHeader();
    }
    var footer = doc.getFooter();
    if (footer) {
      doc.removeFooter();
    }
  } catch(e) {
    // Header/footer doesn't exist or can't be removed
  }

  // Reset all paragraphs to normal text
  var paragraphs = body.getParagraphs();
  for (var i = 0; i < paragraphs.length; i++) {
    var paragraph = paragraphs[i];
    paragraph.setHeading(DocumentApp.ParagraphHeading.NORMAL)
             .setFontFamily('Arial')
             .setFontSize(11)
             .setBold(false)
             .setItalic(false)
             .setIndentStart(0)
             .setIndentFirstLine(0)
             .setAlignment(DocumentApp.HorizontalAlignment.LEFT)
             .setSpacingBefore(0)
             .setSpacingAfter(0)
             .setLineSpacing(1.15);
  }
}

// Format the business plan document
function formatBusinessPlan() {
  var doc = DocumentApp.getActiveDocument();
  var body = doc.getBody();
  
  // Set document margins
  body.setMarginBottom(72);
  body.setMarginTop(72);
  body.setMarginLeft(72);
  body.setMarginRight(72);

  // Format all paragraphs
  var paragraphs = body.getParagraphs();
  for (var i = 0; i < paragraphs.length; i++) {
    var paragraph = paragraphs[i];
    var text = paragraph.getText().trim();
    
    // Skip empty paragraphs
    if (!text) continue;
    
    // Format document title
    if (text.match(/^VIRTUAL LAWYER BUSINESS PLAN/i)) {
      formatTitle(paragraph);
      continue;
    }
    
    // Format main sections (e.g., "1.0 BUSINESS CONCEPT")
    if (/^\d+\.0\s+[A-Z\s]+$/.test(text)) {
      formatMainSection(paragraph);
      continue;
    }
    
    // Format subsections (e.g., "1.1 Vision and Mission")
    if (/^\d+\.\d+\s+[A-Za-z\s]+$/.test(text)) {
      formatSubSection(paragraph);
      continue;
    }
    
    // Format bullet points
    if (text.startsWith('•')) {
      formatBulletPoint(paragraph);
      continue;
    }
    
    // Format normal text
    formatNormalText(paragraph);
  }
  
  // Create table of contents
  createTableOfContents();
}

// Format document title
function formatTitle(paragraph) {
  paragraph.setHeading(DocumentApp.ParagraphHeading.TITLE)
          .setFontFamily('Arial')
          .setFontSize(24)
          .setBold(true)
          .setAlignment(DocumentApp.HorizontalAlignment.CENTER)
          .setSpacingAfter(36);
}

// Format main sections
function formatMainSection(paragraph) {
  paragraph.setHeading(DocumentApp.ParagraphHeading.HEADING1)
          .setFontFamily('Arial')
          .setFontSize(16)
          .setBold(true)
          .setAlignment(DocumentApp.HorizontalAlignment.LEFT)
          .setSpacingBefore(24)
          .setSpacingAfter(12);
}

// Format subsections
function formatSubSection(paragraph) {
  paragraph.setHeading(DocumentApp.ParagraphHeading.HEADING2)
          .setFontFamily('Arial')
          .setFontSize(14)
          .setBold(true)
          .setAlignment(DocumentApp.HorizontalAlignment.LEFT)
          .setSpacingBefore(18)
          .setSpacingAfter(6);
}

// Format bullet points
function formatBulletPoint(paragraph) {
  paragraph.setFontFamily('Arial')
          .setFontSize(11)
          .setIndentStart(36)
          .setSpacingBefore(3)
          .setSpacingAfter(3)
          .setLineSpacing(1.15);
  
  // Ensure text starts with bullet point
  var text = paragraph.getText().trim();
  if (!text.startsWith('•')) {
    text = text.replace(/^[•\-]\s*/, ''); // Remove existing bullets or dashes
    paragraph.setText('• ' + text);
  }
}

// Format normal text
function formatNormalText(paragraph) {
  paragraph.setHeading(DocumentApp.ParagraphHeading.NORMAL)
          .setFontFamily('Arial')
          .setFontSize(11)
          .setAlignment(DocumentApp.HorizontalAlignment.LEFT)
          .setLineSpacing(1.15)
          .setSpacingBefore(6)
          .setSpacingAfter(6);
}

// Create table of contents
function createTableOfContents() {
  var doc = DocumentApp.getActiveDocument();
  var body = doc.getBody();
  
  // Find the position to insert TOC (after title)
  var paragraphs = body.getParagraphs();
  var tocIndex = 1; // After title
  
  // Create TOC heading
  var tocHeading = body.insertParagraph(tocIndex, 'TABLE OF CONTENTS');
  tocHeading.setHeading(DocumentApp.ParagraphHeading.HEADING1)
           .setAlignment(DocumentApp.HorizontalAlignment.CENTER)
           .setBold(true)
           .setSpacingAfter(18);
  
  tocIndex++;
  
  // Insert horizontal line
  var line = body.insertHorizontalRule(tocIndex);
  tocIndex++;
  
  // Collect all headings
  var toc = [];
  for (var i = 0; i < paragraphs.length; i++) {
    var paragraph = paragraphs[i];
    var text = paragraph.getText().trim();
    
    if (/^\d+\.0\s+[A-Z\s]+$/.test(text)) {
      toc.push({
        text: text,
        indent: 0
      });
    } else if (/^\d+\.\d+\s+[A-Za-z\s]+$/.test(text)) {
      toc.push({
        text: text,
        indent: 36
      });
    }
  }
  
  // Insert TOC entries
  for (var i = 0; i < toc.length; i++) {
    var entry = body.insertParagraph(tocIndex + i, '');
    entry.setIndentStart(toc[i].indent)
        .setFontFamily('Arial')
        .setFontSize(11)
        .setSpacingBefore(3)
        .setSpacingAfter(3);
    
    // Add the text
    entry.appendText(toc[i].text);
  }
  
  // Insert another horizontal line after TOC
  tocIndex += toc.length;
  body.insertHorizontalRule(tocIndex);
}
