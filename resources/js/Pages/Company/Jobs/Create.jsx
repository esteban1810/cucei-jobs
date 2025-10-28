import React from 'react';
import { useForm, usePage } from '@inertiajs/react';

export default function Create() {
  const { companies } = usePage().props;
  const { data, setData, post, processing, errors } = useForm({
    company_id: companies[0]?.id || '',
    title: '',
    description: '',
    location: '',
    modality: 'presencial',
    salary_min: '',
    salary_max: '',
    currency: 'MXN',
  });

  const submit = (e) => {
    e.preventDefault();
    post('/company/jobs');
  };

  return (
    <div className="container mx-auto p-6">
      <h1 className="text-2xl font-bold mb-4">Nueva vacante</h1>
      <form onSubmit={submit} className="space-y-4">
        <div>
          <label className="block text-sm mb-1">Empresa</label>
          <select value={data.company_id} onChange={e => setData('company_id', e.target.value)} className="border rounded p-2 w-full">
            {companies.map(c => <option key={c.id} value={c.id}>{c.name}</option>)}
          </select>
          {errors.company_id && <p className="text-red-600 text-sm">{errors.company_id}</p>}
        </div>
        <div>
          <label className="block text-sm mb-1">Título</label>
          <input className="border rounded p-2 w-full" value={data.title} onChange={e => setData('title', e.target.value)} />
          {errors.title && <p className="text-red-600 text-sm">{errors.title}</p>}
        </div>
        <div>
          <label className="block text-sm mb-1">Descripción</label>
          <textarea className="border rounded p-2 w-full" rows={6} value={data.description} onChange={e => setData('description', e.target.value)} />
          {errors.description && <p className="text-red-600 text-sm">{errors.description}</p>}
        </div>
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div>
            <label className="block text-sm mb-1">Ubicación</label>
            <input className="border rounded p-2 w-full" value={data.location} onChange={e => setData('location', e.target.value)} />
          </div>
          <div>
            <label className="block text-sm mb-1">Modalidad</label>
            <select className="border rounded p-2 w-full" value={data.modality} onChange={e => setData('modality', e.target.value)}>
              <option value="presencial">Presencial</option>
              <option value="remoto">Remoto</option>
              <option value="hibrido">Híbrido</option>
            </select>
          </div>
          <div>
            <label className="block text-sm mb-1">Moneda</label>
            <input className="border rounded p-2 w-full" value={data.currency} onChange={e => setData('currency', e.target.value)} />
          </div>
        </div>
        <div className="grid grid-cols-2 gap-4">
          <div>
            <label className="block text-sm mb-1">Salario Mín</label>
            <input type="number" className="border rounded p-2 w-full" value={data.salary_min} onChange={e => setData('salary_min', e.target.value)} />
          </div>
          <div>
            <label className="block text-sm mb-1">Salario Máx</label>
            <input type="number" className="border rounded p-2 w-full" value={data.salary_max} onChange={e => setData('salary_max', e.target.value)} />
          </div>
        </div>
        <button disabled={processing} className="px-4 py-2 bg-blue-600 text-white rounded">Guardar</button>
      </form>
    </div>
  );
}