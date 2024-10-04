async function getTopics(paramsUrl) {
    let connection = await fetch(`http://localhost:8080/topics-json?${paramsUrl}`);

    return await connection.json();
}

async function getTopicsOfDiscipline(disciplineId) {
    let connection = await fetch(`http://localhost:8080/disciplines-topics-json?discipline_id=${disciplineId}`);

    return await connection.json();
}


export const topicApi = {
    getTopics,
    getTopicsOfDiscipline
};