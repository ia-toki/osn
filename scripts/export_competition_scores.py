import csv
import json

with open('scores.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')

    header = next(csv_reader)

    task_ids = list(map(int, header[4:]))
    print('DELETE FROM Submission WHERE Task >= {} AND Task <= {};'.format(task_ids[0], task_ids[-1]))

    rows = list(csv_reader)
    print('INSERT INTO Submission(Contestant, Task, Score) VALUES')

    submissions = []
    for row in rows:
        contestant_id = int(row[1])
        task_scores = row[4:]

        values = []
        for idx, task_score in enumerate(task_scores):
            if task_score:
                values.append('({}, {}, {})'.format(contestant_id, task_ids[idx], int(task_score)))
 
        submissions.append(', '.join(values))

    print(',\n'.join(submissions) + ';')

    for row in rows:
        rank = int(row[0])
        contestant_id = int(row[1])
        score = int(row[2])
        medal = row[3]
        print('UPDATE Contestant SET `Rank`={}, Score={}, Medal="{}" WHERE ID={};'.format(rank, score, medal, contestant_id))
