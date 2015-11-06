import pandas as pd
import os

for i in os.walk('files'):
    filenames = i[2]

numOfFiles = len(filenames)
files = [0 for i in range(numOfFiles)]

for i in range(1,numOfFiles):
	#in mac OS X , from "1" because of DS.store ,in linux or win ,use from "0"
    print filenames[i]
    fileAddress = "files/"+filenames[i]
    files[i] = pd.read_csv(fileAddress)
for i in range(2,numOfFiles):
    files[1] = files[1].merge(files[i], on="NAME")
files[1].to_csv("provinces_news.csv",index=False)

