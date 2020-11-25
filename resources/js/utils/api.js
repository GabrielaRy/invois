
export const fetchFromAres = ico => {
	return axios.post(`/api/ares/${ico}`).then(({ data }) => data);
}

export const fetchCustomer = id => {
	return axios.post(`/api/customer/${id}`).then(({ data }) => data);
}
