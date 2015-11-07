import pandas as pd
import os

for i in os.walk('getData'):
    filenames = i[2]

numOfFiles = len(filenames)
files = [0 for i in range(numOfFiles)]
for i in range(1,numOfFiles):
    print filenames[i]
    fileAddress = "getData/"+filenames[i]
    files[i] = pd.read_csv(fileAddress)
for i in range(2,numOfFiles):
    files[1] = files[1].merge(files[i], on="NAME")
files[1].to_csv("data/provinces_news.csv",index=False)

