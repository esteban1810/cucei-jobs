import React from 'react';
import { Link, useForm, usePage, Head } from '@inertiajs/react';

export default function Show() {
  const { job, auth, flash } = usePage().props;
  const { post, processing } = useForm({ cover_letter: '' });

  const apply = (e) => {
    e.preventDefault();
    post(`/jobs/${job.id}/apply`);
  };

  return (
    <div className="container mx-auto p-6">
      <Head title={job?.title || 'Vacante'} />
      <Link href="/" className="text-blue-600 hover:underline">← Volver</Link>
      <h1 className="text-3xl font-bold mt-2">{job.title}</h1>
      <p className="text-gray-700 mt-2 whitespace-pre-wrap">{job.description}</p>
      <div className="mt-4 text-sm text-gray-600">
        Empresa: {job.company?.name} • {job.location || 'Ubicación no especificada'} • {job.modality}
      </div>
      {/* Mensajes Flash */}
      {flash?.success && (
        <div className="bg-green-100 text-green-800 p-3 mb-4 rounded">
          {flash.success}
        </div>
      )}
      {flash?.error && (
        <div className="bg-red-100 text-red-800 p-3 mb-4 rounded">
          {flash.error}
        </div>
      )}
      {auth?.user && (
        <form onSubmit={apply} className="mt-6">
          <button disabled={processing} className="px-4 py-2 bg-blue-600 text-white rounded">
            Aplicar
          </button>
        </form>
      )}
    </div>
  );
}