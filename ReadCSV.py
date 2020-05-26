# coding: utf8
import csv
f = open('Data.csv','rU')
csv_f = csv.reader(f)


fw = open('myfile.csv', 'w')

for row in csv_f:
  fw.write( "\"0\",\"0\"," + "\"" + row[1].strip() + "\"" + "," + "\"" + row[2].replace("\"","").strip()  + "\"" + "," + "\"" + row[3].replace("\"","").strip()  + "\"" + "," + "\"" + row[4].replace("\"","").strip()  + "\"" + "," + "\"" + row[5].strip()  + "\"" + "," + "\"" + row[6].strip()  + "\"" + "," + "\"" + row[7].strip()  + "\"" + "," + "\"" + row[8].strip()  + "\"" + ","+ "\"" + row[9].strip()  + "\"" +"\n")
# createdByLibraryID,library_id,callNumber,title,author,publisher,publishYear,numPages,price,donatedBy,image
f.close()
