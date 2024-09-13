async function getData() {
    let connection = await fetch('http://localhost:8080/disciplines-json');
    return await connection.json();
}

export const disciplineApiConnection = {
    getData,
}

